<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "{{%video}}".
 *
 * @property string $video_id
 * @property string $title
 * @property string|null $description
 * @property string|null $tags
 * @property int|null $status
 * @property string|null $video_name
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 *
 * @property User $createdBy
 */
class Video extends \yii\db\ActiveRecord
{
    const STATUS_UNLISTED = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * @var \yii\web\UploadedFile
     */
    public $video;
    /**
     * @var \yii\web\UploadedFile
     */
    public $thumpnail;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%video}}';
    }

    public function behaviors(){
        return [
            TimestampBehavior::class,
            [
                'class' => BlameableBehavior::class,
                'updatedByAttribute' => false
            ]
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['video_id', 'title'], 'required'],
            [['description'], 'string'],
            [['status', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['video_id'], 'string', 'max' => 16],
            [['title'], 'string', 'max' => 512],
            [['tags'], 'string', 'max' => 32],
            [['has_thumpnail'], 'string', 'max' => 45],
            [['video_name'], 'string', 'max' => 100],
            [['video_id'], 'unique'],
            ['status','default','value' => self::STATUS_UNLISTED],
            ['has_thumpnail','default','value' => 'None'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'title' => 'Title',
            'description' => 'Description',
            'tags' => 'Tags',
            'status' => 'Status',
            'has_thumpnail' => 'Has Thumpnail',
            'video_name' => 'Video Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'thumpnail' => 'Thumpnail'
        ];
    }

    /**
     * Gets query for [[CreatedBy]].
     *
     * @return \yii\db\ActiveQuery|\common\models\query\UserQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\query\VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\query\VideoQuery(get_called_class());
    }

    // save video with saveAs fucntion after inserting video info to db
    public function save($runValidation = true, $attributeNames = null)
    {
        $isInsert = $this->isNewRecord;
        if($isInsert){
            $this->video_id = Yii::$app->security->generateRandomString(8);
            $this->title = $this->video->name;
            $this->video_name = $this->video->name;
        }
        
        if($this->thumpnail){
            $this->has_thumpnail = 1;
            echo '<script>alert('.$this->has_thumpnail.')</script>';
        }else{
            echo '<script>alert(1)</script>';
        }
        $saved = parent::save($runValidation,$attributeNames);
        if(!$saved){
            return false;
        }
        if($isInsert){
            $videoPath = Yii::getAlias('@frontend/web/storage/videos/'.$this->video_id.'.mp4');
            if(!is_dir(dirname($videoPath))){
                FileHelper::createDirectory(dirname($videoPath)) ;
            }
            $this->video->saveAs($videoPath); 
        }
        if ($this->thumpnail) {
            $thumpnailPath = Yii::getAlias('@frontend/web/storage/thumpnails/'.$this->video_id.'.png');
            if (!is_dir(dirname($thumpnailPath))) {
                FileHelper::createDirectory(dirname($thumpnailPath)) ;
            }
            $this->thumpnail->saveAs($thumpnailPath);
        }
        return true;
    }

    public function getVideoLink(){
        return Yii::$app->params['frontend'].'storage/videos/'.$this->video_id.'.mp4';
    }

    public function getStatusLabels(){
        return [
            self::STATUS_UNLISTED => 'Unlisted',
            self::STATUS_PUBLISHED => 'Published',
        ];
    }
}
