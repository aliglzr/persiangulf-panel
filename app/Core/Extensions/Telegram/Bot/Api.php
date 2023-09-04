<?php


namespace App\Core\Extensions\Telegram\Bot;


use Telegram\Bot\Objects\BaseObject;
use Telegram\Bot\Objects\Message;
use Telegram\Bot\Objects\Message as MessageObject;

class Api extends \Telegram\Bot\Api {
    public function sendMessage(array $params): MessageObject {
        if (isset($params['reply_markup']))
            $params['reply_markup'] = json_encode($params['reply_markup']);
        return parent::sendMessage($params);
    }
    public function sendAudio(array $params): MessageObject {
        if (isset($params['reply_markup']))
            $params['reply_markup'] = json_encode($params['reply_markup']);
        return parent::sendAudio($params);
    }
    public function sendVoice(array $params): MessageObject {
        if (isset($params['reply_markup']))
            $params['reply_markup'] = json_encode($params['reply_markup']);
        return parent::sendVoice($params);
    }


    /**
     * Send text messages.
     *
     * <code>
     * $params = [
     *   'chat_id'                  => '',
     *   'text'                     => '',
     *   'parse_mode'               => '',
     *   'disable_web_page_preview' => '',
     *   'disable_notification'     => '',
     *   'reply_to_message_id'      => '',
     *   'reply_markup'             => '',
     * ];
     * </code>
     *
     * @link https://core.telegram.org/bots/api#sendmessage
     *
     * @param array    $params                   [
     *
     * @var int|string $chat_id                  Required. Unique identifier for the target chat or username of the target channel (in the format @channelusername)
     * @var string     $text                     Required. Text of the message to be sent
     * @var string     $parse_mode               Optional. Send Markdown or HTML, if you want Telegram apps to show bold, italic, fixed-width text or inline URLs in your bot's message.
     * @var bool       $disable_web_page_preview Optional. Disables link previews for links in this message
     * @var bool       $disable_notification     Optional. Sends the message silently. iOS users will not receive a notification, Android users will receive a notification with no sound.
     * @var int        $reply_to_message_id      Optional. If the message is a reply, ID of the original message
     * @var string     $reply_markup             Optional. Additional interface options. A JSON-serialized object for an inline keyboard, custom reply keyboard, instructions to remove reply keyboard or to force a reply from the user.
     *
     * ]
     *
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     *
     * @return MessageObject
     */
    public function copyMessage(array $params): MessageObject
    {
        if (isset($params['reply_markup']))
            $params['reply_markup'] = json_encode($params['reply_markup']);
        $response = $this->post('copyMessage', $params);

        return new MessageObject($response->getDecodedBody());
    }

    public function sendPhoto(array $params): MessageObject {
        if (isset($params['reply_markup']))
            $params['reply_markup'] = json_encode($params['reply_markup']);
        return parent::sendPhoto($params);
    }

    public function editMessageText(array $params) {
        if (isset($params['reply_markup']))
            $params['reply_markup'] = json_encode($params['reply_markup']);
        parent::editMessageText($params);
    }
}