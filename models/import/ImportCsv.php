<?php

namespace app\modules\dashboard\models\import;

use yii;
use yii\base\Model;
use yii\web\UploadedFile;
use app\modules\user\models\User;

class ImportCsv extends Model
{

    /**
     * @var UploadedFile
     */
    public $csvFile;

    public function rules()
    {
        return [
            [['csvFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'csv'],
        ];
    }

    /**
     * Upload file
     * @return bool|string
     */
    public function upload()
    {
        $avatar_upload_dir = Yii::getAlias('@webroot') . User::getImageDir() . User::getUsername();//link to user's images folder
        !is_dir($avatar_upload_dir) ? FileHelper::createDirectory($avatar_upload_dir) : '';//create a user images folder if it does not exist
        if ($this->csvFile->saveAs($avatar_upload_dir . '/' . $this->csvFile->baseName . '.' . $this->csvFile->extension)) {
            return $avatar_upload_dir . '/' . $this->csvFile->baseName . '.' . $this->csvFile->extension;
        } else {
            return false;
        }
    }
}