<?php

namespace App\Enums;

enum TelegramBotActionsEnum: string
{
    case Typing = 'typing';
    case UploadPhoto = 'upload_photo';
    case RecordVideo = 'record_video';
    case UploadDocument = 'upload_document';
    case RecordVoice = 'record_voice';
}
