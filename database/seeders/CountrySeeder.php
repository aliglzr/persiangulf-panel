<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::all()->each(function (Country $country){
            $country->delete();
        });

        $countries = [
            ['name'=>'Afghanistan', 'slug'=>'افغانستان','code'=>'af','flag'=>'flags/afghanistan.svg'],
            ['name'=>'Aland Islands', 'slug'=>'جزایر الند','code'=>'ax','flag'=>'flags/aland-islands.svg'],
            ['name'=>'Albania', 'slug'=>'آلبانی','code'=>'al','flag'=>'flags/albania.svg'],
            ['name'=>'Algeria', 'slug'=>'الجزایر','code'=>'dz','flag'=>'flags/algeria.svg'],
            ['name'=>'American Samoa', 'slug'=>'جزایر ساموآ','code'=>'as','flag'=>'flags/american-samoa.svg'],
            ['name'=>'Andorra', 'slug'=>'آندورا','code'=>'ad','flag'=>'flags/andorra.svg'],
            ['name'=>'Angola', 'slug'=>'آنگولا','code'=>'ao','flag'=>'flags/angola.svg'],
            ['name'=>'Anguilla', 'slug'=>'آنگویلا','code'=>'ai','flag'=>'flags/anguilla.svg'],
            ['name'=>'Antigua and Barbuda', 'slug'=>'آنتیگوا و باربودا','code'=>'ag','flag'=>'flags/antigua-and-barbuda.svg'],
            ['name'=>'Argentina', 'slug'=>'آرژانتین','code'=>'ar','flag'=>'flags/argentina.svg'],
            ['name'=>'Armenia', 'slug'=>'ارمنستان','code'=>'am','flag'=>'flags/armenia.svg'],
            ['name'=>'Aruba', 'slug'=>'آروبا','code'=>'aw','flag'=>'flags/aruba.svg'],
            ['name'=>'Australia', 'slug'=>'استرالیا','code'=>'au','flag'=>'flags/australia.svg'],
            ['name'=>'Austria', 'slug'=>'اتریش','code'=>'at','flag'=>'flags/austria.svg'],
            ['name'=>'Azerbaijan', 'slug'=>'آذربایجان','code'=>'az','flag'=>'flags/azerbaijan.svg'],
            ['name'=>'Bahamas', 'slug'=>'باهاماس','code'=>'bs','flag'=>'flags/bahamas.svg'],
            ['name'=>'Bahrain', 'slug'=>'بحرین','code'=>'bh','flag'=>'flags/bahrain.svg'],
            ['name'=>'Bangladesh', 'slug'=>'بنگلادش','code'=>'bd','flag'=>'flags/bangladesh.svg'],
            ['name'=>'Barbados', 'slug'=>'باربادوس','code'=>'bb','flag'=>'flags/barbados.svg'],
            ['name'=>'Belarus', 'slug'=>'بلاروس','code'=>'by','flag'=>'flags/belarus.svg'],
            ['name'=>'Belgium', 'slug'=>'بلژیک','code'=>'be','flag'=>'flags/belgium.svg'],
            ['name'=>'Belize', 'slug'=>'بلیز','code'=>'bz','flag'=>'flags/belize.svg'],
            ['name'=>'Benin', 'slug'=>'بنین','code'=>'bj','flag'=>'flags/benin.svg'],
            ['name'=>'Bermuda', 'slug'=>'برمودا','code'=>'bm','flag'=>'flags/bermuda.svg'],
            ['name'=>'Bhutan', 'slug'=>'بوتان','code'=>'bt','flag'=>'flags/bhutan.svg'],
            ['name'=>'Bolivia, Plurinational State of', 'slug'=>'بولیوی','code'=>'bo','flag'=>'flags/bolivia.svg'],
            ['name'=>'Bonaire, Sint Eustatius and Saba', 'slug'=>'بونیر، سینت اوستاتیوس و صبا','code'=>'bq','flag'=>'flags/bonaire.svg'],
            ['name'=>'Bosnia and Herzegovina', 'slug'=>'بوسنی و هرزگوین','code'=>'ba','flag'=>'flags/bosnia-and-herzegovina.svg'],
            ['name'=>'Botswana', 'slug'=>'بوتساوا','code'=>'bw','flag'=>'flags/botswana.svg'],
            ['name'=>'Brazil', 'slug'=>'برزیل','code'=>'br','flag'=>'flags/brazil.svg'],
            ['name'=>'British Indian Ocean Territory', 'slug'=>'قلمرو اقیانوس هند بریتانیا','code'=>'io','flag'=>'flags/british-indian-ocean-territory.svg'],
            ['name'=>'Brunei Darussalam', 'slug'=>'برونئی','code'=>'bn','flag'=>'flags/brunei.svg'],
            ['name'=>'Bulgaria', 'slug'=>'بلغارستان','code'=>'bg','flag'=>'flags/bulgaria.svg'],
            ['name'=>'Burkina Faso', 'slug'=>'بورکینافاسو','code'=>'bf','flag'=>'flags/burkina-faso.svg'],
            ['name'=>'Burundi', 'slug'=>'بوروندی','code'=>'bi','flag'=>'flags/burundi.svg'],
            ['name'=>'Cambodia', 'slug'=>'کامبوج','code'=>'kh','flag'=>'flags/cambodia.svg'],
            ['name'=>'Cameroon', 'slug'=>'کامرون','code'=>'cm','flag'=>'flags/cameroon.svg'],
            ['name'=>'Canada', 'slug'=>'کانادا','code'=>'ca','flag'=>'flags/canada.svg'],
            ['name'=>'Cape Verde', 'slug'=>'کیپ ورد','code'=>'cv','flag'=>'flags/cape-verde.svg'],
            ['name'=>'Cayman Islands', 'slug'=>'جزایر کیمن','code'=>'ky','flag'=>'flags/cayman-islands.svg'],
            ['name'=>'Central African Republic', 'slug'=>'جمهوری آفریقای مرکزی','code'=>'cf','flag'=>'flags/central-african-republic.svg'],
            ['name'=>'Chad', 'slug'=>'چاد','code'=>'td','flag'=>'flags/chad.svg'],
            ['name'=>'Chile', 'slug'=>'شیلی','code'=>'cl','flag'=>'flags/chile.svg'],
            ['name'=>'China', 'slug'=>'چین','code'=>'cn','flag'=>'flags/china.svg'],
            ['name'=>'Christmas Island', 'slug'=>'جزیره کریسمس','code'=>'cx','flag'=>'flags/christmas-island.svg'],
            ['name'=>'Cocos (Keeling) Islands', 'slug'=>'جرایز کوکوس ( کیلینگ)','code'=>'cc','flag'=>'flags/cocos-island.svg'],
            ['name'=>'Colombia', 'slug'=>'کلمبیا','code'=>'co','flag'=>'flags/colombia.svg'],
            ['name'=>'Comoros', 'slug'=>'کومور','code'=>'km','flag'=>'flags/comoros.svg'],
            ['name'=>'Cook Islands', 'slug'=>'جزایر کوک','code'=>'ck','flag'=>'flags/cook-islands.svg'],
            ['name'=>'Costa Rica', 'slug'=>'کاستاریکا','code'=>'cr','flag'=>'flags/costa-rica.svg'],
            ['name'=>'Côte d\'Ivoire', 'slug'=>'ساحل عاج','code'=>'ci','flag'=>'flags/ivory-coast.svg'],
            ['name'=>'Croatia', 'slug'=>'کرواسی','code'=>'hr','flag'=>'flags/croatia.svg'],
            ['name'=>'Cuba', 'slug'=>'کوبا','code'=>'cu','flag'=>'flags/cuba.svg'],
            ['name'=>'Curaçao', 'slug'=>'کوراسائو','code'=>'cw','flag'=>'flags/curacao.svg'],
            ['name'=>'Czech Republic', 'slug'=>'جمهوری چک','code'=>'cz','flag'=>'flags/czech-republic.svg'],
            ['name'=>'Denmark', 'slug'=>'دانمارک','code'=>'dk','flag'=>'flags/denmark.svg'],
            ['name'=>'Djibouti', 'slug'=>'جیبوتی','code'=>'dj','flag'=>'flags/djibouti.svg'],
            ['name'=>'Dominica', 'slug'=>'دومینیکا','code'=>'dm','flag'=>'flags/dominica.svg'],
            ['name'=>'Dominican Republic', 'slug'=>'جمهوری دومینیکن','code'=>'do','flag'=>'flags/dominican-republic.svg'],
            ['name'=>'Ecuador', 'slug'=>'اکوادور','code'=>'ec','flag'=>'flags/ecuador.svg'],
            ['name'=>'Egypt', 'slug'=>'مصر','code'=>'eg','flag'=>'flags/egypt.svg'],
            ['name'=>'El Salvador', 'slug'=>'السالوادور','code'=>'sv','flag'=>'flags/el-salvador.svg'],
            ['name'=>'Equatorial Guinea', 'slug'=>'گینه استوایی','code'=>'gq','flag'=>'flags/equatorial-guinea.svg'],
            ['name'=>'Eritrea', 'slug'=>'اریتره','code'=>'er','flag'=>'flags/eritrea.svg'],
            ['name'=>'Estonia', 'slug'=>'استونی','code'=>'ee','flag'=>'flags/estonia.svg'],
            ['name'=>'Ethiopia', 'slug'=>'اتیوپی','code'=>'et','flag'=>'flags/ethiopia.svg'],
            ['name'=>'Falkland Islands (Malvinas)', 'slug'=>'جزایر فالکلند','code'=>'fk','flag'=>'flags/falkland-islands.svg'],
            ['name'=>'Fiji', 'slug'=>'فیجی','code'=>'fj','flag'=>'flags/fiji.svg'],
            ['name'=>'Finland', 'slug'=>'فنلاند','code'=>'fi','flag'=>'flags/finland.svg'],
            ['name'=>'France', 'slug'=>'فرانسه','code'=>'fr','flag'=>'flags/france.svg'],
            ['name'=>'French Polynesia', 'slug'=>'پلینزی فرانسه','code'=>'pf','flag'=>'flags/french-polynesia.svg'],
            ['name'=>'Gabon', 'slug'=>'گابن','code'=>'ga','flag'=>'flags/gabon.svg'],
            ['name'=>'Gambia', 'slug'=>'گامبیا','code'=>'gm','flag'=>'flags/gambia.svg'],
            ['name'=>'Georgia', 'slug'=>'گرجستان','code'=>'ge','flag'=>'flags/georgia.svg'],
            ['name'=>'Germany', 'slug'=>'آلمان','code'=>'de','flag'=>'flags/germany.svg'],
            ['name'=>'Ghana', 'slug'=>'غنا','code'=>'gh','flag'=>'flags/ghana.svg'],
            ['name'=>'Gibraltar', 'slug'=>'جبل الطارق','code'=>'gi','flag'=>'flags/gibraltar.svg'],
            ['name'=>'Greece', 'slug'=>'یونان','code'=>'gr','flag'=>'flags/greece.svg'],
            ['name'=>'Greenland', 'slug'=>'گرینلند','code'=>'gl','flag'=>'flags/greenland.svg'],
            ['name'=>'Grenada', 'slug'=>'گرانادا','code'=>'gd','flag'=>'flags/grenada.svg'],
            ['name'=>'Guam', 'slug'=>'گوام','code'=>'gu','flag'=>'flags/guam.svg'],
            ['name'=>'Guatemala', 'slug'=>'گواتمالا','code'=>'gt','flag'=>'flags/guatemala.svg'],
            ['name'=>'Guernsey', 'slug'=>'گرنزی','code'=>'gg','flag'=>'flags/guernsey.svg'],
            ['name'=>'Guinea', 'slug'=>'گینه','code'=>'gn','flag'=>'flags/guinea.svg'],
            ['name'=>'Guinea-Bissau', 'slug'=>'گینه بیسائو','code'=>'gw','flag'=>'flags/guinea-bissau.svg'],
            ['name'=>'Haiti', 'slug'=>'هائیتی','code'=>'ht','flag'=>'flags/haiti.svg'],
            ['name'=>'Holy See (Vatican City State)', 'slug'=>'شهر واتیکان','code'=>'va','flag'=>'flags/vatican-city.svg'],
            ['name'=>'Honduras', 'slug'=>'هندوراس','code'=>'hn','flag'=>'flags/honduras.svg'],
            ['name'=>'Hong Kong', 'slug'=>'هنگ کنگ','code'=>'hk','flag'=>'flags/hong-kong.svg'],
            ['name'=>'Hungary', 'slug'=>'مجارستان','code'=>'hu','flag'=>'flags/hungary.svg'],
            ['name'=>'Iceland', 'slug'=>'ایسلند','code'=>'is','flag'=>'flags/iceland.svg'],
            ['name'=>'India', 'slug'=>'هند','code'=>'in','flag'=>'flags/india.svg'],
            ['name'=>'Indonesia', 'slug'=>'اندونزی','code'=>'id','flag'=>'flags/indonesia.svg'],
            ['name'=>'Iran, Islamic Republic of', 'slug'=>'ایران','code'=>'ir','flag'=>'flags/iran.svg'],
            ['name'=>'Iraq', 'slug'=>'عراق','code'=>'iq','flag'=>'flags/iraq.svg'],
            ['name'=>'Ireland', 'slug'=>'ایرلند','code'=>'ie','flag'=>'flags/ireland.svg'],
            ['name'=>'Isle of Man', 'slug'=>'جزیره انسان','code'=>'im','flag'=>'flags/isle-of-man.svg'],
            ['name'=>'Israel', 'slug'=>'اسرائیل','code'=>'il','flag'=>'flags/israel.svg'],
            ['name'=>'Italy', 'slug'=>'ایتالیا','code'=>'it','flag'=>'flags/italy.svg'],
            ['name'=>'Jamaica', 'slug'=>'جامائیکا','code'=>'jm','flag'=>'flags/jamaica.svg'],
            ['name'=>'Japan', 'slug'=>'ژاپن','code'=>'jp','flag'=>'flags/japan.svg'],
            ['name'=>'Jersey', 'slug'=>'جرسی','code'=>'je','flag'=>'flags/jersey.svg'],
            ['name'=>'Jordan', 'slug'=>'اردن','code'=>'jo','flag'=>'flags/jordan.svg'],
            ['name'=>'Kazakhstan', 'slug'=>'قزاقستان','code'=>'kz','flag'=>'flags/kazakhstan.svg'],
            ['name'=>'Kenya', 'slug'=>'کنیا','code'=>'ke','flag'=>'flags/kenya.svg'],
            ['name'=>'Kiribati', 'slug'=>'کیریباتی','code'=>'ki','flag'=>'flags/kiribati.svg'],
            ['name'=>'Korea, Democratic People\'s Republic of', 'slug'=>'کره شمالی','code'=>'kp','flag'=>'flags/north-korea.svg'],
            ['name'=>'Kuwait', 'slug'=>'کویت','code'=>'kw','flag'=>'flags/kuwait.svg'],
            ['name'=>'Kyrgyzstan', 'slug'=>'قرقیزستان','code'=>'kg','flag'=>'flags/kyrgyzstan.svg'],
            ['name'=>'Lao People\'s Democratic Republic', 'slug'=>'لائوس','code'=>'la','flag'=>'flags/laos.svg'],
            ['name'=>'Latvia', 'slug'=>'لتونی','code'=>'lv','flag'=>'flags/latvia.svg'],
            ['name'=>'Lebanon', 'slug'=>'لبنان','code'=>'lb','flag'=>'flags/lebanon.svg'],
            ['name'=>'Lesotho', 'slug'=>'لسوتو','code'=>'ls','flag'=>'flags/lesotho.svg'],
            ['name'=>'Liberia', 'slug'=>'لیبریا','code'=>'lr','flag'=>'flags/liberia.svg'],
            ['name'=>'Libya', 'slug'=>'لیبی','code'=>'ly','flag'=>'flags/libya.svg'],
            ['name'=>'Liechtenstein', 'slug'=>'لیختن اشتاین','code'=>'li','flag'=>'flags/liechtenstein.svg'],
            ['name'=>'Lithuania', 'slug'=>'لیتوانی','code'=>'lt','flag'=>'flags/lithuania.svg'],
            ['name'=>'Luxembourg', 'slug'=>'لوکزامبورگ','code'=>'lu','flag'=>'flags/luxembourg.svg'],
            ['name'=>'Macao', 'slug'=>'ماکائو','code'=>'mo','flag'=>'flags/macao.svg'],
            ['name'=>'Madagascar', 'slug'=>'ماداگاسکار','code'=>'mg','flag'=>'flags/madagascar.svg'],
            ['name'=>'Malawi', 'slug'=>'مالاوی','code'=>'mw','flag'=>'flags/malawi.svg'],
            ['name'=>'Malaysia', 'slug'=>'مالزی','code'=>'my','flag'=>'flags/malaysia.svg'],
            ['name'=>'Maldives', 'slug'=>'مالدیو','code'=>'mv','flag'=>'flags/maldives.svg'],
            ['name'=>'Mali', 'slug'=>'مالی','code'=>'ml','flag'=>'flags/mali.svg'],
            ['name'=>'Malta', 'slug'=>'مالت','code'=>'mt','flag'=>'flags/malta.svg'],
            ['name'=>'Marshall Islands', 'slug'=>'جزایر مارشال','code'=>'mh','flag'=>'flags/marshall-island.svg'],
            ['name'=>'Martinique', 'slug'=>'مارتینیک','code'=>'mq','flag'=>'flags/martinique.svg'],
            ['name'=>'Mauritania', 'slug'=>'موریتانی','code'=>'mr','flag'=>'flags/mauritania.svg'],
            ['name'=>'Mauritius', 'slug'=>'موریس','code'=>'mu','flag'=>'flags/mauritius.svg'],
            ['name'=>'Mexico', 'slug'=>'مکزیک','code'=>'mx','flag'=>'flags/mexico.svg'],
            ['name'=>'Micronesia, Federated States of', 'slug'=>'میکرونزی','code'=>'fm','flag'=>'flags/micronesia.svg'],
            ['name'=>'Moldova, Republic of', 'slug'=>'مولداوی','code'=>'md','flag'=>'flags/moldova.svg'],
            ['name'=>'Monaco', 'slug'=>'موناکو','code'=>'mc','flag'=>'flags/monaco.svg'],
            ['name'=>'Mongolia', 'slug'=>'مغولستان','code'=>'mn','flag'=>'flags/mongolia.svg'],
            ['name'=>'Montenegro', 'slug'=>'مونته نگرو','code'=>'me','flag'=>'flags/montenegro.svg'],
            ['name'=>'Montserrat', 'slug'=>'مونتسرات','code'=>'ms','flag'=>'flags/montserrat.svg'],
            ['name'=>'Morocco', 'slug'=>'مراکش','code'=>'ma','flag'=>'flags/morocco.svg'],
            ['name'=>'Mozambique', 'slug'=>'موزامبیک','code'=>'mz','flag'=>'flags/mozambique.svg'],
            ['name'=>'Myanmar', 'slug'=>'میانمار','code'=>'mm','flag'=>'flags/myanmar.svg'],
            ['name'=>'Namibia', 'slug'=>'نامیبیا','code'=>'na','flag'=>'flags/namibia.svg'],
            ['name'=>'Nauru', 'slug'=>'نائورو','code'=>'nr','flag'=>'flags/nauru.svg'],
            ['name'=>'Nepal', 'slug'=>'نپال','code'=>'np','flag'=>'flags/nepal.svg'],
            ['name'=>'Netherlands', 'slug'=>'هلند','code'=>'nl','flag'=>'flags/netherlands.svg'],
            ['name'=>'New Zealand', 'slug'=>'نیوزیلند','code'=>'nz','flag'=>'flags/new-zealand.svg'],
            ['name'=>'Nicaragua', 'slug'=>'نیکاروگوئه','code'=>'ni','flag'=>'flags/nicaragua.svg'],
            ['name'=>'Niger', 'slug'=>'نبجر','code'=>'ne','flag'=>'flags/niger.svg'],
            ['name'=>'Nigeria', 'slug'=>'نیجریه','code'=>'ng','flag'=>'flags/nigeria.svg'],
            ['name'=>'Niue', 'slug'=>'نیوئه','code'=>'nu','flag'=>'flags/niue.svg'],
            ['name'=>'Norfolk Island', 'slug'=>'جزیره نورفولک','code'=>'nf','flag'=>'flags/norfolk-island.svg'],
            ['name'=>'Northern Mariana Islands', 'slug'=>'ماریانای شمالی','code'=>'mp','flag'=>'flags/northern-mariana-islands.svg'],
            ['name'=>'Norway', 'slug'=>'نروژ','code'=>'no','flag'=>'flags/norway.svg'],
            ['name'=>'Oman', 'slug'=>'عمان','code'=>'om','flag'=>'flags/oman.svg'],
            ['name'=>'Pakistan', 'slug'=>'پاکستان','code'=>'pk','flag'=>'flags/pakistan.svg'],
            ['name'=>'Palau', 'slug'=>'پالائو','code'=>'pw','flag'=>'flags/palau.svg'],
            ['name'=>'Palestinian', 'slug'=>'فلسطین','code'=>'ps','flag'=>'flags/palestine.svg'],
            ['name'=>'Panama', 'slug'=>'پاناما','code'=>'pa','flag'=>'flags/panama.svg'],
            ['name'=>'Papua New Guinea', 'slug'=>'پاپوآ گینه نو','code'=>'pg','flag'=>'flags/papua-new-guinea.svg'],
            ['name'=>'Paraguay', 'slug'=>'پاراگوئه','code'=>'py','flag'=>'flags/paraguay.svg'],
            ['name'=>'Peru', 'slug'=>'پرو','code'=>'pe','flag'=>'flags/peru.svg'],
            ['name'=>'Philippines', 'slug'=>'فیلیپین','code'=>'ph','flag'=>'flags/philippines.svg'],
            ['name'=>'Poland', 'slug'=>'لهستان','code'=>'pl','flag'=>'flags/poland.svg'],
            ['name'=>'Portugal', 'slug'=>'پرتغال','code'=>'pt','flag'=>'flags/portugal.svg'],
            ['name'=>'Puerto Rico', 'slug'=>'پورتوریکو','code'=>'pr','flag'=>'flags/puerto-rico.svg'],
            ['name'=>'Qatar', 'slug'=>'قطر','code'=>'qa','flag'=>'flags/qatar.svg'],
            ['name'=>'Romania', 'slug'=>'رومانی','code'=>'ro','flag'=>'flags/romania.svg'],
            ['name'=>'Russian Federation', 'slug'=>'روسیه','code'=>'ru','flag'=>'flags/russia.svg'],
            ['name'=>'Rwanda', 'slug'=>'رواندا','code'=>'rw','flag'=>'flags/rwanda.svg'],
            ['name'=>'Saint Barthélemy', 'slug'=>'سنت بارتلمی','code'=>'bl','flag'=>'flags/st-barts.svg'],
            ['name'=>'Saint Kitts and Nevis', 'slug'=>'سنت کیتس و نویس','code'=>'kn','flag'=>'flags/saint-kitts-and-nevis.svg'],
            ['name'=>'Saint Lucia', 'slug'=>'سنت لوسیا','code'=>'lc','flag'=>'flags/st-lucia.svg'],
            ['name'=>'Saint Martin (French part)', 'slug'=>'سنت مارتین (بخش فرانسوی)','code'=>'mf','flag'=>'flags/sint-maarten.svg'],
            ['name'=>'Saint Vincent and the Grenadines', 'slug'=>'سنت وینسنت و گرنادین ها','code'=>'vc','flag'=>'flags/st-vincent-and-the-grenadines.svg'],
            ['name'=>'Samoa', 'slug'=>'ساموآ','code'=>'ws','flag'=>'flags/samoa.svg'],
            ['name'=>'San Marino', 'slug'=>'سن مارینو','code'=>'sm','flag'=>'flags/san-marino.svg'],
            ['name'=>'Sao Tome and Principe', 'slug'=>'سائوتومه و پرنسیپ','code'=>'st','flag'=>'flags/sao-tome-and-prince.svg'],
            ['name'=>'Saudi Arabia', 'slug'=>'عربستان سعودی','code'=>'sa','flag'=>'flags/saudi-arabia.svg'],
            ['name'=>'Senegal', 'slug'=>'سنگال','code'=>'sn','flag'=>'flags/senegal.svg'],
            ['name'=>'Serbia', 'slug'=>'صربستان','code'=>'rs','flag'=>'flags/serbia.svg'],
            ['name'=>'Seychelles', 'slug'=>'سیشل','code'=>'sc','flag'=>'flags/seychelles.svg'],
            ['name'=>'Sierra Leone', 'slug'=>'سیرا لئون','code'=>'sl','flag'=>'flags/sierra-leone.svg'],
            ['name'=>'Singapore', 'slug'=>'سنگاپور','code'=>'sg','flag'=>'flags/singapore.svg'],
            ['name'=>'Sint Maarten (Dutch part)', 'slug'=>'سینت مارتن (بخش هلندی)','code'=>'sx','flag'=>'flags/sint-maarten.svg'],
            ['name'=>'Slovakia', 'slug'=>'اسلواکی','code'=>'sk','flag'=>'flags/slovakia.svg'],
            ['name'=>'Slovenia', 'slug'=>'اسلوونی','code'=>'si','flag'=>'flags/slovenia.svg'],
            ['name'=>'Solomon Islands', 'slug'=>'جزایر سلیمان','code'=>'sb','flag'=>'flags/solomon-islands.svg'],
            ['name'=>'Somalia', 'slug'=>'سومالی','code'=>'so','flag'=>'flags/somalia.svg'],
            ['name'=>'South Africa', 'slug'=>'آفریقای جنوبی','code'=>'za','flag'=>'flags/south-africa.svg'],
            ['name'=>'South Korea', 'slug'=>'کره جنوبی','code'=>'kr','flag'=>'flags/south-korea.svg'],
            ['name'=>'South Sudan', 'slug'=>'سودان جنوبی','code'=>'ss','flag'=>'flags/south-sudan.svg'],
            ['name'=>'Spain', 'slug'=>'اسپانیا','code'=>'es','flag'=>'flags/spain.svg'],
            ['name'=>'Sri Lanka', 'slug'=>'سریلانکا','code'=>'lk','flag'=>'flags/sri-lanka.svg'],
            ['name'=>'Sudan', 'slug'=>'سودان','code'=>'sd','flag'=>'flags/sudan.svg'],
            ['name'=>'Suriname', 'slug'=>'سورینام','code'=>'sr','flag'=>'flags/suriname.svg'],
            ['name'=>'Swaziland', 'slug'=>'سوازیلند','code'=>'sz','flag'=>'flags/swaziland.svg'],
            ['name'=>'Sweden', 'slug'=>'سوئد','code'=>'se','flag'=>'flags/sweden.svg'],
            ['name'=>'Switzerland', 'slug'=>'سوئیس','code'=>'ch','flag'=>'flags/switzerland.svg'],
            ['name'=>'Syrian Arab Republic', 'slug'=>'سوریه','code'=>'sy','flag'=>'flags/syria.svg'],
            ['name'=>'Taiwan, Province of China', 'slug'=>'تایوان','code'=>'tw','flag'=>'flags/taiwan.svg'],
            ['name'=>'Tajikistan', 'slug'=>'تاجیکستان','code'=>'tj','flag'=>'flags/tajikistan.svg'],
            ['name'=>'Tanzania, United Republic of', 'slug'=>'تانزانیا','code'=>'tz','flag'=>'flags/tanzania.svg'],
            ['name'=>'Thailand', 'slug'=>'تایلند','code'=>'th','flag'=>'flags/thailand.svg'],
            ['name'=>'Togo', 'slug'=>'توگو','code'=>'tg','flag'=>'flags/togo.svg'],
            ['name'=>'Tokelau', 'slug'=>'توکلائو','code'=>'tk','flag'=>'flags/tokelau.svg'],
            ['name'=>'Tonga', 'slug'=>'تونگا','code'=>'to','flag'=>'flags/tonga.svg'],
            ['name'=>'Trinidad and Tobago', 'slug'=>'ترینیداد و توباگو','code'=>'tt','flag'=>'flags/trinidad-and-tobago.svg'],
            ['name'=>'Tunisia', 'slug'=>'تونس','code'=>'tn','flag'=>'flags/tunisia.svg'],
            ['name'=>'Turkey', 'slug'=>'ترکیه','code'=>'tr','flag'=>'flags/turkey.svg'],
            ['name'=>'Turkmenistan', 'slug'=>'ترکمنستان','code'=>'tm','flag'=>'flags/turkmenistan.svg'],
            ['name'=>'Turks and Caicos Islands', 'slug'=>'جزایر تورکس و کایکوس','code'=>'tc','flag'=>'flags/turks-and-caicos.svg'],
            ['name'=>'Tuvalu', 'slug'=>'تووالو','code'=>'tv','flag'=>'flags/tuvalu.svg'],
            ['name'=>'Uganda', 'slug'=>'اوگاندا','code'=>'ug','flag'=>'flags/uganda.svg'],
            ['name'=>'Ukraine', 'slug'=>'اوکراین','code'=>'ua','flag'=>'flags/ukraine.svg'],
            ['name'=>'United Arab Emirates', 'slug'=>'امارات متحده عربی','code'=>'ae','flag'=>'flags/united-arab-emirates.svg'],
            ['name'=>'United Kingdom', 'slug'=>'انگلستان','code'=>'gb','flag'=>'flags/united-kingdom.svg'],
            ['name'=>'United States', 'slug'=>'ایالات متحده آمریکا','code'=>'us','flag'=>'flags/united-states.svg'],
            ['name'=>'Uruguay', 'slug'=>'اروگوئه','code'=>'uy','flag'=>'flags/uruguay.svg'],
            ['name'=>'Uzbekistan', 'slug'=>'ازبکستان','code'=>'uz','flag'=>'flags/uzbekistan.svg'],
            ['name'=>'Vanuatu', 'slug'=>'وانواتو','code'=>'vu','flag'=>'flags/vanuatu.svg'],
            ['name'=>'Venezuela, Bolivarian Republic of', 'slug'=>'ونزوئلا','code'=>'ve','flag'=>'flags/venezuela.svg'],
            ['name'=>'Vietnam', 'slug'=>'ویتنام','code'=>'vn','flag'=>'flags/vietnam.svg'],
            ['name'=>'Virgin Islands', 'slug'=>'جزایر ویرجین ایالات متحده','code'=>'vi','flag'=>'flags/virgin-islands.svg'],
            ['name'=>'Yemen', 'slug'=>'یمن','code'=>'ye','flag'=>'flags/yemen.svg'],
            ['name'=>'Zambia', 'slug'=>'زامبیا','code'=>'zm','flag'=>'flags/zambia.svg'],
            ['name'=>'Zimbabwe', 'slug'=>'زیمبابوه','code'=>'zw','flag'=>'flags/zimbabwe.svg'],
        ];
        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}