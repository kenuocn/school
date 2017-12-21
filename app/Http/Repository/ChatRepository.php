<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/17
 * Time: 下午10:15
 */

namespace App\Http\Repository;


use App\ChatMessage;

class ChatRepository
{
    protected $chatMessage;

    public function __construct(ChatMessage $chatMessage)
    {
        $this->chatMessage = $chatMessage;
    }

    /**
     * 发送聊天消息
     *
     * @author yezi
     *
     * @param $fromId
     * @param $toId
     * @param $content
     * @param $attachments
     * @param $type
     * @param $post_at
     * @return mixed
     */
    public function saveChatMessage($fromId,$toId,$content,$attachments,$type,$post_at)
    {
        $result = ChatMessage::create([
            ChatMessage::FIELD_ID_FROM_USER=>$fromId,
            ChatMessage::FIELD_ID_TO=>$toId,
            ChatMessage::FIELD_CONTENT=>$content,
            ChatMessage::FIELD_ATTACHMENTS=>$attachments,
            ChatMessage::FIELD_TYPE=>$type,
            ChatMessage::FIELD_POST_AT=>$post_at
        ]);

        return $result;
    }

    public function chatList($userId,$friendId)
    {
        return $this->chatMessage->query()->where(function ($query)use($userId,$friendId){
            $query->where(ChatMessage::FIELD_ID_FROM_USER,$userId)->where(ChatMessage::FIELD_ID_TO,$friendId);
        })->orWhere(function ($query)use($userId,$friendId){
            $query->where(ChatMessage::FIELD_ID_FROM_USER,$friendId)->where(ChatMessage::FIELD_ID_TO,$userId);
        })->get();
    }

}