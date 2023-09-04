<?php /** @noinspection DuplicatedCode */
/** @noinspection SpellCheckingInspection */

/** @noinspection PhpConditionAlreadyCheckedInspection */

namespace App\Http\Controllers\Api\Bot;

use App;
use App\Core\Extensions\Telegram\Bot\Api;
use App\Core\Extensions\Verta\Verta;
use App\Http\Controllers\Controller;
use App\Models\Inbound;
use App\Models\Layer;
use App\Models\Option;
use App\Models\Server;
use App\Models\Transaction;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Shetabit\Multipay\Abstracts\Driver;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Update;
use Telegram\Bot\Objects\User;

class BotController extends Controller
{
    public Api $bot;
    public Update $update;
    public User $from;
    public null|App\Models\User $user;
    public null|App\Models\Payment $payment;

    /**
     * All Telegram webhook requests will come to this function
     */
    public function index(): void
    {
        try {

            $this->bot = new Api(Option::get('sales_bot_token') ?? config('services.telegram-bot-api.token'));
            $this->update = $this->bot->getWebhookUpdate();

            if ($this->update->message != null) {
                $this->from = $this->update->message->from;
            } else if ($this->update->callbackQuery != null) {
                $this->from = $this->update->callbackQuery->from;
            }
            if (!isset($this->from)) {
                return;
            }
            $from = $this->from;
            $fromId = $this->from->id;
            $bot = $this->bot;
//            if ($this->from->id != 206277306 && $this->from->id != 1370612811 && $this->from->id != 25041871 && $this->from->id != 352104022) {
//                $this->bot->sendMessage([
//                    'chat_id' => $this->from->id,
//                    'text' => "باعرض پوزش در حال حاضر امکان استفاده از ربات وجود ندارد.",
//                    'reply_markup' => $this->getButtons('back_to_main')
//                ]);
//                return;
//            }
            $sendInvitedMessage = false;
            $this->user = App\Models\User::where('tid', $this->from->id)->first();
            if (is_null($this->user)) {
                $this->user = new App\Models\User();
                $solidSale = \App\Models\User::where('username', 'solidvpn_sales')->first();
                if (is_null($solidSale)) {
                    $this->bot->sendMessage([
                        'chat_id' => $this->from->id,
                        'text' => "باعرض پوزش در حال حاضر امکان استفاده از ربات وجود ندارد.",
                        'reply_markup' => $this->getButtons('back_to_main')
                    ]);
                    return;
                }

                $this->user->reference_id = $solidSale->id;

                if (str_starts_with($this->update->message->text, "/start")) {
                    if ($this->update->message->text != "/start") {
                        $inviteCode = explode(" ", $this->update->message->text)[1];
                        $inviter = \App\Models\User::role("client")->where('invite_code', $inviteCode)->first();
                        if ($inviter != null) {
                            $this->user->invited_by = $inviter->id;
                            $sendInvitedMessage = true;
                        }
                    }
                }
//                if (!empty($this->invite_code)) {
//                    /** @var User $inviterUser */
//                    $inviterUser = User::where('invite_code', $this->invite_code)->first();
//                    $this->user->invited_by = $inviterUser->id;
//                    if ($inviterUser->isAgent()) {
//                        $this->user->reference_id = $inviterUser->id;
//                    }
//                }

                // TODO: #863gvrunx
                $this->user->tid = $this->from->id;
                $this->user->from_bot = true;
                $this->user->first_name = $this->from->firstName;
                $this->user->last_name = $this->from->lastName;
                $this->user->email = null;
                $this->user->username = \App\Models\User::generateUsername();
                $this->user->password = bcrypt(\App\Models\User::generatePassword());
                $this->user->layer_id = Layer::getClientLayer()->id;
                $this->user->invite_code = \App\Models\User::generateInviteCode();
                $this->user->save();
                $this->user->assignRole('client');
                $this->user->setData('email_subscription', true);
            }
            $this->user->first_name = $this->from->firstName;
            $this->user->last_name = $this->from->lastName;
            $this->user->save();

            if ($sendInvitedMessage) {
                $invitedId = convertNumbers($this->user->id);
                $this->bot->sendMessage([
                    'chat_id' => $inviter->tid,
                    'text' => "✅ یک کاربر با شناسه کاربری  $invitedId با کد معرف شما عضو ربات سالید وی پی ان شده است. درصورت خرید اشتراک ۱۰ درصد از مبلغ خرید اول کاربر موردنظر به عنوان هدیه به حساب کاربری شما و ایشان اضافه می‌شود.",
                ]);
            }
            // TODO: #863gvrwbp

            // Checks that if force join enabled then check if user is joined in those channels or not
            if (!$this->checkForceJoin()) {
                return;
            }

            if ($this->update->message != null) {
                $message = $this->update->message;
                $messageText = $this->update->message->text;

                switch ($messageText) {
                    case "/android" :
                    {
                        $this->bot->sendMessage([
                            'chat_id' => $this->from->id,
                            'text' => "📱 راهنمای استفاده در گوشی های اندروید

📌نام برنامه: v2rayNG
<a href='https://play.google.com/store/apps/details?id=com.v2ray.ang'>🔗لینک دانلود از گوگل پلی</a>
<a href='https://github.com/2dust/v2rayNG/releases/download/1.8.5/v2rayNG_1.8.5.apk'>🔗لینک دانلود مستقیم آخرین نسخه</a>

📖راهنما:
1. وارد بخش مدیریت اشتراک شوید سپس روی دریافت کانفیگ کلیک کنید.
2. کشور و سرور موردنظر خود را انتخاب نمایید.
3. یکسری متن شامل متن کانفیگ و کیوآرکد نمایش داده میشود، روی متن کانفیگ کلیک کنید تا کپی شود.
4. وارد اپلیکیشن موردنظر شوید.
5. از داخل اپلیکیشن روی آیکون + که در گوشه اپ وجود دارد کلیک کرده و روی گزینه import config from clipboard کلیک نمایید.
6. اکنون سرور موردنظر شما به اپلیکیشن اضافه شده است و با انتخاب کانفیگ موردنظر و کلیک روی دکمه سبز رنگ پایین اپلیکیشن به سالید وی پی ان متصل شوید.",
                            'reply_markup' => $this->getButtons('back_to_main'),
                            'parse_mode' => "HTML",
                        ]);
                        break;
                    }
                    case "/ios" :
                    {
                        $this->bot->sendMessage([
                            'chat_id' => $this->from->id,
                            'text' => "📱 راهنمای استفاده در گوشی های ios

📌نام برنامه: Fair VPN
<a href='https://apps.apple.com/us/app/fair-vpn/id1533873488'>🔗لینک دانلود از اپ استور</a>

 📖راهنما:
1. وارد بخش مدیریت اشتراک شوید سپس روی دریافت کانفیگ کلیک کنید.
2. کشور و سرور موردنظر خود را انتخاب نمایید.
3. یکسری متن شامل متن کانفیگ و کیوآرکد نمایش داده میشود، روی متن کانفیگ کلیک کنید تا کپی شود.
4. وارد اپلیکیشن موردنظر شوید.
5. از دو طریق میتوانید کانفیگ را اضافه کنید یا از طریق QR code یا از طریق import vpn config
6 اگر import vpn config را انتخاب کردید. از داخل پنل یا ربات کانفیگ را کپی کنید و در این قسمت قرار دهید.
7. سپس کانفیگ ادد شده را انتخاب کنید و از قسمت status آن را فعال کنید.

———————————————

📌نام برنامه: Napsternetv
<a href='https://apps.apple.com/us/app/napsternetv/id1629465476'>🔗لینک دانلود از اپ استور</a>


 📖راهنما:
1. وارد بخش مدیریت اشتراک شوید سپس روی دریافت کانفیگ کلیک کنید.
2. کشور و سرور موردنظر خود را انتخاب نمایید.
3. یکسری متن شامل متن کانفیگ و کیوآرکد نمایش داده میشود، روی متن کانفیگ کلیک کنید تا کپی شود.
4. وارد اپلیکیشن موردنظر شوید.
5. از داخل اپلیکیشن روی بخش Config کلیک کنید.
6. سپس روی آیکون + در بالای اپ کلیک نمایید.
7. سپس روی گزینه import v2ray url from clipboard کلیک کنید.
8. پس از اضافه شدن کانفیگ موردنظر در قسمت Home روی آیکون پلی که رنگ آبی دارد کلیک کنید تا به سالید وی پی ان متصل شوید.",
                            'reply_markup' => $this->getButtons('back_to_main'),
                            'parse_mode' => "HTML",
                        ]);
                        break;
                    }
                    case "/banner" :
                    {
                        $inviteLink = "https://t.me/" . (Option::get('sales_bot_username') ?? "OfficialSolidVPNBot") . "?start=" . $this->user->invite_code;
                        $this->bot->sendPhoto([
                            'chat_id' => $this->from->id,
                            'photo' => "AgACAgQAAxkBAAIBOmSd1ubA2tu873QH6_UBqK3DKF4xAALxvTEbp3npUIH-0s74X4YJAQADAgADeQADLwQ",
                            'caption' => "🚀 تجربه سرعتی بی نهایت با سالید وی پی ان
فراتر از انتظار شما، همراه شما هستیم!

ویژگی های سالید وی پی ان👇🏻

⚡️ سرعت باورنکردنی
✈️ ارائه کانفیگ با آیپی کشورهای مختلف
✔️ پشتیبانی ۲۴ ساعته
🤖 خرید و تحویل آنی سرویس ها از سایت و ربات تلگرام
♾بدون محدودیت کاربر
📶 فعال بر روی تمامی اپراتورها و شبکه ها
🔗 قابلیت استفاده از کانکشن هوشمند
📬 فاقد تبلیغات
💣 بدون قطعی و کندی سرعت

با استفاده از لینک زیر و جذب مشتری ۱۰ درصد از مبلغ خرید اول مشتری معرفی شده به عنوان هدیه به حساب کاربری شما و ایشان اضافه میشود.

💰 خرید : $inviteLink

.",
                        ]);
                        break;
                    }
//                    case "/linux" : {
//                        $this->bot->sendMessage([
//                            'chat_id' => $this->from->id,
//                            'text' => "⚠️ مقدار وارد شده یک عدد صحیح نمی باشد.\n❗️لطفاً مجدداً مبلغ دلخواه را ( به تومان ) جهت افزایش موجودی حساب کاربری خود ارسال نمایید.",
//                            'reply_markup' => $this->getButtons('back_to_main')
//                        ]);
//                        break;
//                    }
//                    case "/windows" : {
//                        $this->bot->sendMessage([
//                            'chat_id' => $this->from->id,
//                            'text' => "⚠️ مقدار وارد شده یک عدد صحیح نمی باشد.\n❗️لطفاً مجدداً مبلغ دلخواه را ( به تومان ) جهت افزایش موجودی حساب کاربری خود ارسال نمایید.",
//                            'reply_markup' => $this->getButtons('back_to_main')
//                        ]);
//                        break;
//                    }
//                    case "/mac" : {
//                        $this->bot->sendMessage([
//                            'chat_id' => $this->from->id,
//                            'text' => "⚠️ مقدار وارد شده یک عدد صحیح نمی باشد.\n❗️لطفاً مجدداً مبلغ دلخواه را ( به تومان ) جهت افزایش موجودی حساب کاربری خود ارسال نمایید.",
//                            'reply_markup' => $this->getButtons('back_to_main')
//                        ]);
//                        break;
//                    }
                    default:
                    {
                        if (str_starts_with($messageText, '/start login_')) {
                            $data = str_replace('/start ', '', $messageText);
                            if (str_starts_with($data, 'login_')) {
                                $code = str_replace('login_', '', $data);
                                $this->loginWithCode($code);
                                return;
                            }
                        }
                        if (preg_match("/[0-9A-Fa-f]{8}/i", $messageText)) {
                            $this->loginWithCode($messageText);
                            return;
                        }
                        switch ($this->user->getStep()) {
                            case 'increase_balance':
                            {
                                $amount = convertNumbers($messageText, 'en');

                                $this->increaseBalance($amount);
                                break;
                            }
                            case 'main':
                            default:
                                $this->mainMessage();
                                break;
                        }
                    }
                }
            } else if ($this->update->callbackQuery != null) {
                $query = $this->update->callbackQuery;
                $queryMessage = $this->update->callbackQuery->message;
                $messageId = $queryMessage->messageId;
                $queryData = $query->data;

                switch ($queryData) {
                    case 'check_force_join':
                    {
                        $this->bot->answerCallbackQuery([
                            'callback_query_id' => $query->id,
                            'show_alert' => false,
                            'text' => "✅ عضویت شما تأیید شد.",
                        ]);
                        $this->bot->deleteMessage([
                            'chat_id' => $from->id,
                            'message_id' => $messageId,
                        ]);
                        $this->mainMessage();
                        break;
                    }
                    case 'main':
                    {
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => Option::get('sales_bot_start_message') ?? "به ربات تلگرامی Solid VPN خوش آمدید😍",
                            'reply_markup' => $this->getButtons('main')
                        ]);
                        $this->user->setStep('main');
                        break;
                    }
                    case 'buy_subscription':
                    {
                        $solidSale = \App\Models\User::where('username', 'solidvpn_sales')->first();
                        if (is_null($solidSale)) {
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "باعرض پوزش در حال حاضر امکان استفاده از ربات وجود ندارد.",
                                'reply_markup' => $this->getButtons('back_to_main')
                            ]);
                            return;
                        }
                        if ($this->user->getReservedSubscription()) {
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "⚠️ شما در حال حاضر یک اشتراک فعال و یک اشتراک به صورت رزرو دارید و امکان خرید اشتراک جدید وجود ندارد.",
                                'reply_markup' => $this->getButtons('back_to_main')
                            ]);
                            return;
                        }
                        $subscriptionDurations = [];
                        $plans = $solidSale->plans()->where('remaining_user_count', '>', 0)->where('plan_user.active', true)->select('plan_duration')->distinct()->pluck('plan_duration');
                        if (count($plans) <= 0) {
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "باعرض پوزش در حال حاضر امکان استفاده از ربات وجود ندارد.",
                                'reply_markup' => $this->getButtons('back_to_main')
                            ]);
                            return;
                        }
                        $column = 0;
                        $row = 0;
                        foreach ($plans as $planDuration) {
                            if ($column == 3) {
                                $column = 0;
                                $row++;
                                $subscriptionDurations[$row] = [];
                            }
                            $subscriptionDurations[$row][] = ["text" => convertNumbers($planDuration) . " روز", "callback_data" => "buy_subscription_select_time_" . $planDuration];

                            $column++;
                        }
                        $subscriptionDurations[] = [
                            ["text" => "➡️ بازگشت", "callback_data" => "main"]
                        ];
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "🛒 خرید اشتراک\n🔷 لطفاً مدت زمان اشتراک را انتخاب کنید.",
                            'reply_markup' => [
                                'resize_keyboard' => true,
                                'inline_keyboard' => $subscriptionDurations
                            ]
                        ]);
                        break;
                    }
                    case 'increase_balance':
                    {
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "🔸 برای خرید اشتراک میبایست ابتدا موجودی حساب خود را افزایش دهید.\n🔹 جهت افزایش موجودی حساب کاربری خود مبلغ دلخواه خود را ( به تومان ) ارسال نمایید.",
                            'reply_markup' => $this->getButtons('back_to_main')
                        ]);
                        $this->user->setStep('increase_balance');
                        break;
                    }
                    case 'subscription_management':
                    {
                        if (!$this->user->hasActiveSubscription()) {
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "⚠️ شما در حال حاضر اشتراک فعالی ندارید، لطفاً نسبت به خرید اشتراک از منو اصلی اقدام فرمایید.",
                                'reply_markup' => $this->getButtons('back_to_main')
                            ]);
                            return;
                        }
                        $subscription = $this->user->getCurrentSubscription();
                        $remainingDays = convertNumbers(\Illuminate\Support\Carbon::instance($subscription?->ends_at)->diffInDays());
                        $totalTraffic = convertNumbers(formatBytes($subscription->total_traffic));
                        $endDate = Verta::instance($subscription?->ends_at)->persianFormat('j F Y H:i:s') . " ( $remainingDays روز باقی مانده )";
                        $remainingTraffic = convertNumbers(formatBytes($subscription->remaining_traffic));
                        $totalUsage = convertNumbers(formatBytes($this->user->trafficUsage()));
                        $totalDownload = convertNumbers(formatBytes($this->user->trafficDownloadUsage()));
                        $totalUpload = convertNumbers(formatBytes($this->user->trafficUploadUsage()));
                        $reservedSubscription = $this->user->getReservedSubscription();
                        if ($reservedSubscription) {
                            $duration = convertNumbers($reservedSubscription->duration);
                            $reservedTraffic = convertNumbers(formatBytes($reservedSubscription->total_traffic));
                            $reserveText = "✅ شما دارای اشتراک رزرو $reservedTraffic $duration روزه می باشید.";
                        } else {
                            $reserveText = "❌ شما دارای اشتراک رزرو نمی باشید.";
                        }
                        app('url')->forceRootUrl("https://" . (Option::get('APP_URL')) . "/");
                        $subscriptionLink = URL::signedRoute('v2ray.subscription', ["uuid" => encrypt($this->user->uuid)]);
                        app('url')->forceRootUrl("https://" . request()->httpHost() . "/");
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "🚀 مدیریت اشتراک\n\n\n🔋 حجم کل اشتراک : $totalTraffic\n🔗 <a href='$subscriptionLink'>لینک Subscription</a>\n📆 تاریخ پایان اشتراک : $endDate \n\n📊 جزئیات مصرف 🔻\n\n📈 حجم باقی مانده : $remainingTraffic\n📉 مصرف کل : $totalUsage\n📥 بارگیری : $totalDownload\n📤 بارگذاری : $totalUpload\n\n\n" . $reserveText,
                            'parse_mode' => "html",
                            'reply_markup' => $this->getButtons('subscription_management')
                        ]);


                        break;
                    }
                    case 'get_config':
                    {
                        if (!$this->user->hasActiveSubscription()) {
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "⚠️ شما در حال حاضر اشتراک فعالی ندارید، لطفاً نسبت به خرید اشتراک از منو اصلی اقدام فرمایید.",
                                'reply_markup' => $this->getButtons('back_to_main')
                            ]);
                            return;
                        }

                        $countryButtons = [];
                        $countries = [];
                        foreach (\App\Models\Country::all()->filter(function (\App\Models\Country $country) {
                            return $country->servers()->where('layer_id', $this->user->layer_id)
                                    ->where('available', true)
                                    ->where('active', true)
                                    ->count() > 0;
                        }) as $value) {
                            $count = $value->servers()->where('layer_id', $this->user->layer_id)->get()->count();
                            if ($count) {
                                $countries[] = $value;
                            }
                        }

                        $column = 0;
                        $row = 0;
                        /** @var App\Models\Country $country */
                        foreach ($countries as $country) {
                            if ($column == 3) {
                                $column = 0;
                                $row++;
                                $countryButtons[$row] = [];
                            }
                            $serversCount = convertNumbers($country->servers()
                                ->where('layer_id', $this->user->layer_id)
                                ->where('available', true)
                                ->where('active', true)
                                ->count());
                            $countryButtons[$row][] = ["text" => "‏" . countryToFlag($country->code) . " " . $country->slug . " ( $serversCount )", "callback_data" => "get_config_country_selected_" . $country->id];

                            $column++;
                        }
                        $countryButtons[] = [
                            ["text" => "➡️ بازگشت", "callback_data" => "subscription_management"]
                        ];
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "🏳️ انتخاب کشور\n🔸 لطفاً جهت دریافت کانفیگ ابتدا کشور مورد نظر خود را انتخاب کنید.",
                            'reply_markup' => [
                                'resize_keyboard' => true,
                                'inline_keyboard' => $countryButtons
                            ]
                        ]);


                        break;
                    }
                    case 'my_profile':
                    {
                        $buttons = [];
                        app('url')->forceRootUrl("https://" . (Option::get('APP_URL')) . "/");
                        $redircetUrl = URL::signedRoute('login.user', ['uuid' => encrypt($this->user->uuid)], now()->addMinutes(5));
                        app('url')->forceRootUrl("https://" . request()->httpHost() . "/");
                        $buttons[] = [
                            ["text" => "➡️ بازگشت", "callback_data" => "main"],
                            ["text" => "🔑 ورود به پنل", "url" => $redircetUrl],
                            ["text" => "👥 زیر مجموعه", "callback_data" => "sub_collection"],
                        ];
                        $id = convertNumbers($this->user->id);
                        $username = $this->user->username;
                        $name = $this->user->full_name;
                        $lastLogin = Verta::instance($this->user->getData('last_login'))->persianFormat('j F Y H:i:s');
                        $registerDate = Verta::instance($this->user->created_at)->persianFormat('j F Y H:i:s');
                        $giftCode = strtoupper($this->user->invite_code);
                        $balance = convertNumbers(number_format($this->user->balance)) . " تومان";
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "👤 پروفایل شما\n\n‏🆔 شناسه : $id\n‏🪪 نام کاربری : $username\n📌 نام : $name\n💰 موجودی حساب : $balance\n🔑 آخرین ورود به پنل : $lastLogin\n✏️ تاریخ ثبت نام : $registerDate\n🎁 کد معرف : $giftCode\n\n❕ با استفاده از دکمه ورود به پنل می توانید بدون نیاز به نام کاربری و رمز عبور به طور مستقیم وارد حساب کاربری خود شوید!\n⚠️ دکمه ورود به پنل تنها ۵ دقیقه بعد از ورود به منو 'پروفایل من' قابل استفاده است.",
                            'reply_markup' => [
                                'resize_keyboard' => true,
                                'inline_keyboard' => $buttons
                            ]
                        ]);
                        break;
                    }
                    case 'sub_collection':
                    {
                        $buttons = [];
                        $buttons[] = [
                            ["text" => "➡️ بازگشت", "callback_data" => "my_profile"],
                            ["text" => "🖼 بنر تبلیغاتی شما", "callback_data" => "advertise_banner"],
                        ];
                        $directCount = convertNumbers(number_format($this->user->invited()->count())) . " نفر";
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "👥 زیر مجموعه\n\n🔸 در این قسمت شما می‌توانید تعداد زیرمجموعه های خود به همراه بنر تبلیغاتی خود را مشاهده کنید.\n\n👤 تعداد کاربران معرفی شده توسط شما : $directCount\n\n🎁 با ارسال بنر تبلیغاتی خود به دوستانتان و جذب مشتری از طریق لینک دعوت اختصاصی خودتان، ۱۰ درصد از مبلغ خرید اول مشتری معرفی شده به عنوان هدیه به حساب کاربری شما و ایشان اضافه می شود.",
                            'reply_markup' => [
                                'resize_keyboard' => true,
                                'inline_keyboard' => $buttons
                            ]
                        ]);
                        break;
                    }
                    case 'advertise_banner':
                    {
                        $inviteLink = "https://t.me/" . (Option::get('sales_bot_username') ?? "OfficialSolidVPNBot") . "?start=" . $this->user->invite_code;
                        $this->bot->sendPhoto([
                            'chat_id' => $this->from->id,
                            'photo' => "AgACAgQAAxkBAAIBOmSd1ubA2tu873QH6_UBqK3DKF4xAALxvTEbp3npUIH-0s74X4YJAQADAgADeQADLwQ",
                            'caption' => "🚀 تجربه سرعتی بی نهایت با سالید وی پی ان
فراتر از انتظار شما، همراه شما هستیم!

ویژگی های سالید وی پی ان👇🏻

⚡️ سرعت باورنکردنی
✈️ ارائه کانفیگ با آیپی کشورهای مختلف
✔️ پشتیبانی ۲۴ ساعته
🤖 خرید و تحویل آنی سرویس ها از سایت و ربات تلگرام
♾بدون محدودیت کاربر
📶 فعال بر روی تمامی اپراتورها و شبکه ها
🔗 قابلیت استفاده از کانکشن هوشمند
📬 فاقد تبلیغات
💣 بدون قطعی و کندی سرعت

با استفاده از لینک زیر و جذب مشتری ۱۰ درصد از مبلغ خرید اول مشتری معرفی شده به عنوان هدیه به حساب کاربری شما و ایشان اضافه میشود.

💰 خرید : $inviteLink

.",
                        ]);
                        break;
                    }
                    case 'user_guide':
                    {
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "📌راهنمای استفاده از ربات

📖 راهنما استفاده از سالید وی پی ان
جهت دریافت راهنمای استفاده از سالید وی پی ان باتوجه به گوشی یا سیستم عامل موردنظر خود، روی یکی از عبارات زیر کلیک نمایید:
/android
/ios

💰افزایش موجودی
در این بخش شما میتوانید موجودی حساب کاربری خود را افزایش دهید. با افزایش موجودی میتوانید اشتراک موردنظر خود را از طریق منوی 🛒 خرید اشتراک خریداری نمایید.

🛒 خرید اشتراک
در این بخش شما میتوانید با مشاهده طرحهای موجود بسته وی پی ان دلخواه خود را انتخاب کرده و با افزایش موجودی حساب کاربری آن را خریداری نمایید.

👤 پروفایل من
با کلیک روی دکمه پروفایل من می‌توانید به نام کاربری و اطلاعات کاربری خود دسترسی داشته باشید و همچنین با کلیک بر روی دکمه ورود به پنل، از طریق ربات به پنل کاربری خود وارد شوید.

🚀 مدیریت اشتراک
در این قسمت شما می‌توانید به جزییات اشتراک فعالتون، لینک Subscription، زمان اشتراک، جزئیات مصرف و دریافت کانفیگ دسترسی داشته باشید.
پس از ورود به این قسمت با کلیک بر روی دریافت کانفیگ و انتخاب کشور و سرور موردنظر خود، کانفیگ برای اتصال به سالید وی پی ان دریافت می‌کنید.

📭 پشتیبانی
ارتباط با واحد پشتیبانی و راههای ارتباطی با سالید وی پی ان در این قسمت قرار دارد.",
                            'reply_markup' => $this->getButtons('back_to_main')
                        ]);
                        break;
                    }
                    case 'support':
                    {
                        $this->bot->editMessageText([
                            'chat_id' => $this->from->id,
                            'message_id' => $messageId,
                            'text' => "➖ کاربر گرامی جهت ارتباط بهتر با پشتیبانی SolidVPN لطفاً متن زیر را مطالعه کنید

📖 درصورت بروز مشکل در اتصال شما از طریق مدیریت اشتراک در ربات یا از طریق پیشخان پنل کاربری خود، از وضعیت اشتراک فعالتون آگاه شوید. (درصورتیکه اشتراک فعال ندارید از طریق پنل کاربری یا ربات تلگرامی نسبت به خرید طرح جدید اقدام کنید و از ارسال پیام به پشتیبانی برای خرید طرح خودداری نمایید.)

⚠️ ممکن است در پایداری اتصال به دلیل مشکلات اینترنت ایران ایراداتی به وجود بیاید که به صورت خودکار توسط ما حل می‌شوند؛ احتیاج به پیگیری نیست و فقط کانال اخبار ما را دنبال کنید تا از وضعیت سرورهای فعال ما آگاه شوید ( @SolidVPNNews ). فقط در صورتی که بیش از یک روز از مشکل گذشت و حل نشد، به پشتیبانی پیام دهید.

📌 برای ارتباط با پشتیبانی لطفا در یک پیام نام کاربری خود که با آن خرید کرده‌اید به همراه توضیحات کامل مشکل ، اسکرین‌‌شات از مشکل موردنظر و سیستم‌عاملتان (اندروید، ios، ویندوز، لینوکس، مک) را شرح دهید. (در یک پیام)

⛔️ در صورت ارسال پیام به صورت مکرر پاسخ‌گویی به شما و سایر عزیزان دچار تأخیر می‌گردد. لطفا به این نکته مهم توجه کنید.

🕑 با توجه به تعداد زیاد مشتریان، پاسخ‌گویی ممکن است با تاخیر باشد. پیشاپیش از این بابت از شما پوزش می‌خواهیم و تمام تلاش خود را می‌کنیم که تمامی مشکلات در اسرع وقت حل شود.


💬 آیدی ارتباط با پشتیبانی در تلگرام:

🚀 @SolidVPNSupport

👥ارتباط با پشتیبانی و گفتگو آنلاین در پنل کاربری:

🔗 Panel.SolidMP.cloud/support/tickets",
                            'reply_markup' => $this->getButtons('back_to_main')
                        ]);
                        break;
                    }
                    default:
                    {
                        if (str_starts_with($queryData, 'buy_subscription_select_time_')) {
                            $planDuration = str_replace('buy_subscription_select_time_', '', $queryData);
                            if (!is_numeric($planDuration)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            $solidSale = \App\Models\User::where('username', 'solidvpn_sales')->first();
                            if (is_null($solidSale)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            $subscriptionTraffics = [];
                            $plans = $solidSale->plans()->where('remaining_user_count', '>', 0)->where('plan_user.active', true)->where('plan_duration', $planDuration)->select(['plan_traffic'])->orderBy('plan_traffic')->distinct()->get()->toArray();

                            $column = 0;
                            $row = 0;
                            foreach ($plans as $plan) {
                                if ($column == 3) {
                                    $column = 0;
                                    $row++;
                                    $subscriptionTraffics[$row - 1] = array_reverse($subscriptionTraffics[$row - 1]);
                                    $subscriptionTraffics[$row] = [];
                                }
                                $subscriptionTraffics[$row][] = ["text" => convertNumbers(formatBytes($plan['plan_user']['plan_traffic'])), "callback_data" => "buy_subscription_select_plan_" . $plan['plan_user']['id']];

                                $column++;
                            }
                            $subscriptionTraffics[$row] = array_reverse($subscriptionTraffics[$row]);
                            $subscriptionTraffics[] = [
                                ["text" => "➡️ بازگشت", "callback_data" => "buy_subscription"]
                            ];
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "🛒 خرید اشتراک\n📆 مدت زمان : $planDuration روز\n🔷 لطفاً حجم اشتراک را انتخاب کنید.",
                                'reply_markup' => [
                                    'resize_keyboard' => true,
                                    'inline_keyboard' => $subscriptionTraffics
                                ]
                            ]);
                            return;
                        } else if (str_starts_with($queryData, 'buy_subscription_select_plan_')) {
                            $planUserId = str_replace('buy_subscription_select_plan_', '', $queryData);
                            if (!is_numeric($planUserId)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.($planUserId)",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            $planUser = App\Models\PlanUser::find($planUserId);
                            if (is_null($planUser)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.(1002)",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            $isReserve = false;
                            if ($this->user->hasActiveSubscription()) {
                                if ($this->user->getReservedSubscription()) {
                                    $this->bot->editMessageText([
                                        'chat_id' => $this->from->id,
                                        'message_id' => $messageId,
                                        'text' => "⚠️ شما در حال حاضر یک اشتراک فعال و یک اشتراک به صورت رزرو دارید و امکان خرید اشتراک جدید وجود ندارد.",
                                        'reply_markup' => $this->getButtons('back_to_main')
                                    ]);
                                    return;
                                }
                                $isReserve = true;
                            }
                            $traffic = convertNumbers(formatBytes($planUser->plan_traffic));
                            $duration = convertNumbers($planUser->plan_duration) . " روز";
                            $inventory = convertNumbers(number_format($planUser->remaining_user_count)) . " عدد";
                            $price = $planUser->plan_sell_price == 0 ? "رایگان :)" : convertNumbers(number_format($planUser->plan_sell_price)) . " تومان";
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => $isReserve
                                    ? "🛒 خرید اشتراک رزرو\n🔋 حجم : $traffic\n📆 مدت زمان : $duration\n📦 تعداد موجودی : $inventory\n💰 قیمت : $price\n⚠️ توجه شما در حال حاضر یک اشتراک فعال دارید، این اشتراک به شکل رزرو برای شما ثبت خواهد شد.\n❗️در صورت خرید اشتراک امکان لغو آن تنها در صورت وجود مشکل و با تماس با پشتیبانی امکان پذیر است."
                                    : "🛒 خرید اشتراک\n🔋 حجم : $traffic\n📆 مدت زمان : $duration\n📦 تعداد موجودی : $inventory\n💰 قیمت : $price\n❗️در صورت خرید اشتراک امکان لغو آن تنها در صورت وجود مشکل و با تماس با پشتیبانی امکان پذیر است.",
                                'reply_markup' => [
                                    'resize_keyboard' => true,
                                    'inline_keyboard' => [
                                        [
                                            ["text" => "➡️ بازگشت", "callback_data" => 'buy_subscription_select_time_' . $planUser->plan_duration],
                                            ["text" => "✅ خرید", "callback_data" => 'buy_subscription_plan_user_' . $planUser->id],

                                        ]
                                    ]
                                ]
                            ]);
                            return;
                        } else if (str_starts_with($queryData, 'buy_subscription_plan_user_')) {
                            $planUserId = str_replace('buy_subscription_plan_user_', '', $queryData);
                            if (!is_numeric($planUserId)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            $planUser = App\Models\PlanUser::find($planUserId);
                            if (is_null($planUser)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            if ($planUser->only_bot) {
                                $hadThisSubscriptionBefore = $this->user->subscriptions()->where('plan_user_id', $planUserId)->get()->count();
                                if ($hadThisSubscriptionBefore) {
                                    $this->bot->answerCallbackQuery([
                                        'callback_query_id' => $this->update->callbackQuery->id,
                                        'show_alert' => true,
                                        'text' => "❗️مشتری گرامی شما قبلا این اشتراک را دریافت کرده اید. جهت تهیه اشتراک، سایر موارد را انتخاب بفرمایید.",
                                    ]);
                                    return;
                                }
                            }
                            $isReserve = false;
                            if ($this->user->hasActiveSubscription()) {
                                if ($this->user->getReservedSubscription()) {
                                    $this->bot->editMessageText([
                                        'chat_id' => $this->from->id,
                                        'message_id' => $messageId,
                                        'text' => "⚠️ شما در حال حاضر یک اشتراک فعال و یک اشتراک به صورت رزرو دارید و امکان خرید اشتراک جدید وجود ندارد.",
                                        'reply_markup' => $this->getButtons('back_to_main')
                                    ]);
                                    return;
                                }
                                $isReserve = true;
                            }
                            $traffic = convertNumbers(formatBytes($planUser->plan_traffic));
                            $duration = convertNumbers($planUser->plan_duration);
                            $subscriptionBuyResult = (new App\Http\Livewire\Client\Subscription\SubscriptionItem())->buySubscription(true, $this->user, $planUser);

                            if ($subscriptionBuyResult != 200) {
                                switch ($subscriptionBuyResult) {
                                    case 1011:
                                    case 1012:
                                    case 1013:
                                    case 1014:
                                        Log::error(2);
                                        $this->bot->editMessageText([
                                            'chat_id' => $this->from->id,
                                            'message_id' => $messageId,
                                            'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.",
                                            'reply_markup' => $this->getButtons('back_to_main')
                                        ]);
                                        break;
                                    case 1015:
                                    {
                                        Log::error(3);
                                        $lowAmount = $planUser->plan_sell_price - $this->user->balance;
                                        $deficiencyAmount = convertNumbers(number_format($lowAmount));
                                        $this->bot->editMessageText([
                                            'chat_id' => $this->from->id,
                                            'message_id' => $messageId,
                                            'text' => "❗️ لطفاً جهت خرید اشتراک ابتدا اعتبار خود را به مبلغ $deficiencyAmount تومان افزایش دهید!",
                                            'reply_markup' => [
                                                'resize_keyboard' => true,
                                                'inline_keyboard' => [
                                                    [
                                                        ["text" => "➡️ بازگشت", "callback_data" => "main"],
                                                        ["text" => "💰افزایش موجودی", "callback_data" => "increase_balance_" . $lowAmount],
                                                    ],
                                                ]
                                            ]
                                        ]);
                                        break;
                                    }
                                }
                                return;
                            }

                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => $isReserve
                                    ? "✅ رزرو اشتراک $traffic $duration روزه با موفقیت انجام شد."
                                    : "✅ خرید اشتراک $traffic $duration روزه با موفقیت انجام شد.",
                                'reply_markup' => $this->getButtons('back_to_main')

                            ]);
                            return;
                        } else if (str_starts_with($queryData, 'get_config_country_selected_')) {
                            $countryId = str_replace('get_config_country_selected_', '', $queryData);
                            if (!is_numeric($countryId)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان دریافت کانفیگ وجود ندارد.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            /** @var App\Models\Country $country */
                            $country = App\Models\Country::find($countryId);
                            if (is_null($country)) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان دریافت کانفیگ وجود ندارد.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            $servers = $country->servers()->where('available', true)
                                ->where('active', true)->where('layer_id', $this->user->layer_id)->get();
                            if (!$servers->count()) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر در این کشور سروری وجود ندارد.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            if (!$this->user->hasActiveSubscription()) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "⚠️ شما در حال حاضر اشتراک فعالی ندارید، لطفاً نسبت به خرید اشتراک از منو اصلی اقدام فرمایید.",
                                    'reply_markup' => $this->getButtons('back_to_main')
                                ]);
                                return;
                            }
                            $serversButtons = [];

                            $column = 0;
                            $row = 0;
                            /** @var App\Models\Country $country */
                            foreach ($servers as $key => $server) {
                                $i = convertNumbers($key + 1);
                                if ($column == 3) {
                                    $column = 0;
                                    $row++;
                                    $serversButtons[$row] = [];
                                }
                                $serversCount = convertNumbers($country->servers()
                                    ->where('layer_id', $this->user->layer_id)
                                    ->where('available', true)
                                    ->where('active', true)
                                    ->count());
                                $serverLoad = intval(min((($server->tcp_count + $server->udp_count) / $server->max_connections) * 100, 100));
                                $prefixEmoji = "🟢";
                                if ($serverLoad > 30) {
                                    $prefixEmoji = "🟡";
                                }
                                if ($serverLoad > 60) {
                                    $prefixEmoji = "🟠";
                                }
                                if ($serverLoad > 80) {
                                    $prefixEmoji = "🔴";
                                }
                                $serverLoad = convertNumbers($serverLoad);
                                $serversButtons[$row][] = ["text" => "‏" . countryToFlag($country->code) . " " . $country->slug . " #$i - ( $prefixEmoji $serverLoad ٪ )", "callback_data" => "get_config_server_selected_" . $server->id];

                                $column++;
                            }
                            $serversButtons[] = [
                                ["text" => "➡️ بازگشت", "callback_data" => "get_config"]
                            ];
                            $countryFlag = countryToFlag($country->code);
                            $countryName = $country->slug;
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "‏$countryFlag انتخاب سرور از کشور $countryName \n🔸 لطفاً جهت دریافت کانفیگ سرور مورد نظر خود را انتخاب کنید",
                                'reply_markup' => [
                                    'resize_keyboard' => true,
                                    'inline_keyboard' => $serversButtons
                                ]
                            ]);
                            return;
                        } else if (str_starts_with($queryData, 'get_config_server_selected_')) {
                            $serverId = str_replace('get_config_server_selected_', '', $queryData);
                            if (!is_numeric($serverId)) {

                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان خرید اشتراک وجود ندارد.",
                                    'reply_markup' => [
                                        'resize_keyboard' => true,
                                        'inline_keyboard' => [
                                            [
                                                ["text" => "➡️ بازگشت", "callback_data" => "main"]
                                            ]
                                        ]
                                    ]
                                ]);
                                return;
                            }
                            /** @var App\Models\Server $server */
                            $server = App\Models\Server::find($serverId);
                            if (is_null($server) && !$server->available && !$server->active) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "باعرض پوزش در حال حاضر امکان دریافت کانفیگ از این سرور وجود ندارد.",
                                    'reply_markup' => [
                                        'resize_keyboard' => true,
                                        'inline_keyboard' => [
                                            [
                                                ["text" => "➡️ بازگشت", "callback_data" => "get_config_country_selected_" . $server->country->id]
                                            ]
                                        ]
                                    ]
                                ]);
                                return;
                            }
                            if (!$this->user->hasActiveSubscription()) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "⚠️ شما در حال حاضر اشتراک فعالی ندارید، لطفاً نسبت به خرید اشتراک از منو اصلی اقدام فرمایید.",
                                    'reply_markup' => [
                                        'resize_keyboard' => true,
                                        'inline_keyboard' => [
                                            [
                                                ["text" => "➡️ بازگشت", "callback_data" => "get_config_country_selected_" . $server->country->id]
                                            ]
                                        ]
                                    ]
                                ]);
                                return;
                            }
                            $serverLoad = intval(min((($server->tcp_count + $server->udp_count) / $server->max_connections) * 100, 100));
                            $prefixEmoji = "🟢";
                            if ($serverLoad > 30) {
                                $prefixEmoji = "🟡";
                            }
                            if ($serverLoad > 60) {
                                $prefixEmoji = "🟠";
                            }
                            if ($serverLoad > 80) {
                                $prefixEmoji = "🔴";
                            }
                            $serverLoad = $prefixEmoji . " " . convertNumbers($serverLoad) . " ٪";
                            $country = countryToFlag($server->country->code) . " " . $server->country->slug;
                            activity('دریافت کانکشن')->event('getConnection')->causedBy(auth()->user())->performedOn($this->user)->withProperties(['server' => $server->toArray(), 'operator' => "ALL"])->log('دریافت کانکشن');

                            $rateLimiterKey = "get-connection-" . $this->user->id;
                            if (RateLimiter::tooManyAttempts($rateLimiterKey, 1000)) {
                                $seconds = RateLimiter::availableIn($rateLimiterKey);
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "تعداد درخواست شما بیش از حد مجاز است. لطفا پس از $seconds ثانیه تلاش کنید.",
                                    'reply_markup' => [
                                        'resize_keyboard' => true,
                                        'inline_keyboard' => [
                                            [
                                                ["text" => "➡️ بازگشت", "callback_data" => "get_config_country_selected_" . $server->country->id]
                                            ]
                                        ]
                                    ]
                                ]);
                                return;
                            }
                            $inbound = new Inbound();
                            $inbound->layer($server->layer_id);
                            $configLink = "";
                            try {
                                $configLink = $inbound->getConnectionConfig($this->user, $server);
                            } catch (\Exception $e) {
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "خطا در دریافت کانکشن، لطفا بعدا تلاش کنید.",
                                    'reply_markup' => [
                                        'resize_keyboard' => true,
                                        'inline_keyboard' => [
                                            [
                                                ["text" => "➡️ بازگشت", "callback_data" => "get_config_country_selected_" . $server->country->id]
                                            ]
                                        ]
                                    ]
                                ]);
                                return;
                            }
                            if ($configLink == "") {
                                Log::error("Connection creator returned null!");
                                $this->bot->editMessageText([
                                    'chat_id' => $this->from->id,
                                    'message_id' => $messageId,
                                    'text' => "خطا در دریافت کانکشن، لطفا بعدا تلاش کنید.",
                                    'reply_markup' => [
                                        'resize_keyboard' => true,
                                        'inline_keyboard' => [
                                            [
                                                ["text" => "➡️ بازگشت", "callback_data" => "get_config_country_selected_" . $server->country->id]
                                            ]
                                        ]
                                    ]
                                ]);
                                return;
                            }
                            $qrcode = "https://chart.googleapis.com/chart?chs=400x400&cht=qr&chl=" . $configLink;
                            $this->bot->editMessageText([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                                'text' => "<a href='$qrcode'>🚀</a> دریافت کانفیگ \n\n🏳️ کشور : $country\n📈 بار سرور : $serverLoad\n\n‏🔗 لینک کانفیگ : \n<code>$configLink</code>\n\n\n⚠️ توجه فرمایید در صورت اتمام حجم کانفیگ ها بلافاصله قطع خواهد شد و به شما اطلاع داده می شود.",
                                'parse_mode' => 'html',
                                'reply_markup' => [
                                    'resize_keyboard' => true,
                                    'inline_keyboard' => [
                                        [
                                            ["text" => "➡️ بازگشت", "callback_data" => "get_config_country_selected_" . $server->country->id]
                                        ]
                                    ]
                                ]
                            ]);
                            return;
                        } else if (str_starts_with($queryData, 'increase_balance_')) {
                            $amount = str_replace('increase_balance_', '', $queryData);
                            $amount = intval($amount);
                            $this->increaseBalance($amount);
                            $this->bot->deleteMessage([
                                'chat_id' => $this->from->id,
                                'message_id' => $messageId,
                            ]);
                        }
                        $this->bot->answerCallbackQuery(['callback_query_id' => $query->id]);
                    }
                }
            }

        } catch (Exception $exception) {
            Log::error("Bot: " . $exception->getMessage());
        }
    }

    /**
     * @throws TelegramSDKException
     */
    private function checkForceJoin(): bool
    {
        if (!Option::get('sales_bot_force_join')) {
            return true;
        }
        $channels = json_decode(Option::get('sales_bot_force_join_channels'), true);
        $joinedChannel = 0;
        foreach ($channels as $channel) {
            if ($this->isJoinedInChannel($channel['id'])) {
                $joinedChannel++;
            }
        }
        if ($joinedChannel == count($channels)) {
            return true;
        }
        if ($this->update->callbackQuery != null) {
            $this->bot->answerCallbackQuery([
                'callback_query_id' => $this->update->callbackQuery->id,
                'show_alert' => true,
                'text' => "❗️ عضویت شما تأیید نشد.",
            ]);
            return false;
        }
        $channelButtons = [];
        foreach ($channels as $channel) {
            $channelButtons[] =
                [
                    ["text" => "عضویت در کانال " . $channel['name'], "url" => $channel['join_link']]
                ];
        }
        $channelButtons[] =
            [
                ["text" => "عضو شدم ✅", "callback_data" => "check_force_join"]
            ];
        $this->bot->sendMessage([
            'chat_id' => $this->from->id,
            'text' => Option::get('sales_bot_force_join_message') ?? "برای کار با ربات باید ابتدا در کانال های زیر عضو شوید ...",
            'reply_markup' => array(
                'resize_keyboard' => true,
                'inline_keyboard' => $channelButtons
            )
        ]);
        return false;
    }

    private function isJoinedInChannel($chatId): bool
    {
        //“creator”, “administrator”, “member”, “restricted”, “left” or “kicked”
        try {
            $chatMember = $this->bot->getChatMember(['chat_id' => $chatId, 'user_id' => $this->from->id]);
            if ($chatMember->status == "creator" || $chatMember->status == "administrator" || $chatMember->status == "member" || $chatMember->status == "restricted") {
                return true;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return false;
    }

    /**
     * @throws TelegramSDKException
     */
    private function mainMessage()
    {
        $sentMessage = $this->bot->sendMessage([
            'chat_id' => $this->from->id,
//            'photo' => "AgACAgQAAxkBAAMlZHW84VUJ0fAKrgABBPZnBEgzXI9nAAJ7wTEbb3uwU7VNiykqH5xjAQADAgADeQADLwQ",
            'text' => Option::get('sales_bot_start_message') ?? "به ربات تلگرامی Solid VPN خوش آمدید😍",
            'reply_markup' => $this->getButtons('main')
        ]);
    }

    private function getButtons($button): array
    {
        switch ($button) {
            case 'back_to_main':
            {
                return array(
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ["text" => "➡️ بازگشت", "callback_data" => "main"],
                        ],
                    ]
                );
            }
            case 'subscription_management':
            {
                return array(
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ["text" => "➡️ بازگشت", "callback_data" => "main"],
                            ["text" => "🚀 دریافت کانفیگ", "callback_data" => "get_config"],
                        ],
                    ]
                );
            }
            case 'main':
            {
                return array(
                    'resize_keyboard' => true,
                    'inline_keyboard' => [
                        [
                            ["text" => "🛒 خرید اشتراک", "callback_data" => "buy_subscription"],
                            ["text" => "💰 افزایش موجودی", "callback_data" => "increase_balance"],
                        ],
                        [
                            ["text" => "🚀 مدیریت اشتراک", "callback_data" => "subscription_management"],
                            ["text" => "👤 پروفایل من", "callback_data" => "my_profile"],
                        ],
                        [
                            ["text" => "📖 راهنما استفاده", "callback_data" => "user_guide"],
                            ["text" => "📭 پشتیبانی", "callback_data" => "support"],
                        ],
                    ]
                );
            }
            case 'empty_inline':
            {
                return array(
                    'resize_keyboard' => true,
                    'inline_keyboard' => []
                );
            }
            default:
            {
                return [];
            }
        }
    }

    /**
     * @throws TelegramSDKException
     */
    private function increaseBalance(mixed $amount)
    {
        if (!is_numeric($amount)) {
            $this->bot->sendMessage([
                'chat_id' => $this->from->id,
                'text' => "⚠️ مقدار وارد شده یک عدد صحیح نمی باشد.\n❗️لطفاً مجدداً مبلغ دلخواه را ( به تومان ) جهت افزایش موجودی حساب کاربری خود ارسال نمایید.",
                'reply_markup' => $this->getButtons('back_to_main')
            ]);
            return;
        }
        $minimum_payment = Option::get('minimum_payment') ?? 10000;
        $maximum_payment = 50000000; // 50,000,000 IRT
        if ($amount < $minimum_payment) {
            $this->bot->sendMessage([
                'chat_id' => $this->from->id,
                'text' => "⚠️ حداقل مبلغ جهت افزایش موجودی، " . convertNumbers(number_format($minimum_payment)) . " تومان می باشد.",
                'reply_markup' => $this->getButtons('back_to_main')
            ]);
            return;
        }
        if ($amount > $maximum_payment) {
            $this->bot->sendMessage([
                'chat_id' => $this->from->id,
                'text' => "⚠️ حداکثر مبلغ جهت افزایش موجودی، " . convertNumbers(number_format($maximum_payment)) . " تومان می باشد.",
                'reply_markup' => $this->getButtons('back_to_main')
            ]);
            return;
        }
        if (empty(Option::get('payment_status'))) {
            $this->bot->sendMessage([
                'chat_id' => $this->from->id,
                'text' => "❗️با عرض پوزش، امکان افزایش اعتبار موقتا غیر فعال است.",
                'reply_markup' => $this->getButtons('back_to_main')
            ]);
            return;
        }
        $invoice = new Invoice();

        // Set invoice amount.
        try {
            $invoice->amount($amount);
        } catch (\Exception $e) {
            $this->bot->sendMessage([
                'chat_id' => $this->from->id,
                'text' => "❗️خطا در ارتباط با درگاه، لطفا دوباره امتحان کنید.",
                'reply_markup' => $this->getButtons('back_to_main')
            ]);
            Log::error($e);
            return;
        }
        $showAmount = convertNumbers(number_format($amount));
        $invoice->detail(['increaseBalance' => "افزایش اعتبار از طریق ربات به مبلغ $showAmount تومان "]);
        $url = null;
        try {
            app('url')->forceRootUrl("https://" . (Option::get('APP_URL')) . "/");
            $url = json_decode(
                Payment::callbackUrl(route('pay.callback'))
                    ->purchase($invoice, function (Driver $driver, $transactionId) use ($amount) {
                        $this->payment = new \App\Models\Payment();
                        $this->payment->amount = $amount;
                        $this->payment->gateway_transaction_id = $transactionId;
                        $this->payment->gateway_driver = get_class($driver);
                        $this->payment->status = 'pending';
                        $this->payment->user_id = $this->user->id;
                        $this->payment->data = [];
                        $this->payment->save();
                    })
                    ->pay()
                    ->toJson()
            )->action;
        } catch (\Exception $e) {
            $this->bot->sendMessage([
                'chat_id' => $this->from->id,
                'text' => "❗️خطا در ارتباط با درگاه، لطفا دوباره امتحان کنید.",
                'reply_markup' => $this->getButtons('back_to_main')
            ]);
            Log::critical($e);
            return;
        }
        if (is_null($url)) {
            $this->bot->sendMessage([
                'chat_id' => $this->from->id,
                'text' => "❗️خطا در ارتباط با درگاه، لطفا دوباره امتحان کنید.",
                'reply_markup' => $this->getButtons('back_to_main')
            ]);
            Log::error("Bot: Url is empty - E1879");
            return;
        }
        $redircetUrl = URL::temporarySignedRoute('go.url', now()->addMinutes(5), ['url' => encrypt($url)]);
        app('url')->forceRootUrl("https://" . request()->httpHost() . "/");
        $paymentDate = Verta::now()->persianFormat("j F Y H:i:s");
        $sentMessage = $this->bot->sendMessage([
            'chat_id' => $this->from->id,
            'text' => "🔸 افزایش موجودی\n💰 مبلغ : $showAmount تومان \n💳 روش پرداخت : درگاه پرداخت شاپرک\n📆 تاریخ : $paymentDate\n🕑 مدت اعتبار: ۱۰ دقیقه\n📌 در صورتی که از ادامه عملیات پرداخت اطمینان دارید، فیلترشکن خود را خاموش کرده و دکمه پرداخت را بزنید.",
            'reply_markup' => [
                'resize_keyboard' => true,
                'inline_keyboard' => [
                    [
                        ["text" => "➡️ بازگشت", "callback_data" => "main"],
                        ["text" => "✅ پرداخت", "url" => $redircetUrl],
                    ],
                ]
            ]
        ]);
        $this->payment->data = [
            "bot_message_id" => $sentMessage->messageId,
        ];
        $this->payment->save();
        $this->user->setStep('main');
    }

    /**
     * @throws TelegramSDKException
     */
    private function loginWithCode(array|string $code)
    {
        if (preg_match("/[0-9A-Fa-f]{8}/i", $code)) {
            /** @var App\Models\AuthToken $authToken */
            try {
                \DB::transaction(function () use ($code) {
                    $authToken = App\Models\AuthToken::where('code', $code)->get()->first();
                    if (empty($authToken) || $authToken->created_at < now()->subMinutes(10) || $authToken->token != null || $authToken->user_id != null) {
                        $this->bot->sendMessage([
                            'chat_id' => $this->from->id,
                            'text' => "❗️ کد وارد شده صحیح نمی باشد.",
                        ]);
                        return;
                    }
                    do {
                        $token = \Str::random(128);
                    } while (App\Models\AuthToken::where('token', $token)->get()->count() > 0);
                    $authToken->token = $token;
                    $authToken->user_id = $this->user->id;
                    $authToken->save();
                    event(new App\Events\TelegramLoginCode($authToken));
                    $this->bot->sendMessage([
                        'chat_id' => $this->from->id,
                        'text' => "✅ احراز هویت با موفقیت انجام شد.
📌 عملیات ورود به حساب کاربری به طور خودکار در مرورگر شما انجام خواهد شد.",
                    ]);
                });
            } catch (\Throwable $e) {
                $this->bot->sendMessage([
                    'chat_id' => $this->from->id,
                    'text' => "❗️ خطا در احراز هویت، لطفاً دوباره امتحان کنید.",
                ]);
            }
        }
    }


}
