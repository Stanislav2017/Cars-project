<?php

namespace app\controllers;

use app\models\Brand;
use app\models\CarDevice;
use app\models\Device;
use app\models\Image;
use app\models\ImageUpload;
use app\models\Type;
use app\traits\ImageTrait;
use function array_diff;
use function array_merge;
use function array_unique;
use function array_values;
use const false;
use function file_exists;
use function get_class;
use function getimagesize;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\ManipulatorInterface;
use function implode;
use function is_null;
use function json_encode;
use function md5;
use function print_r;
use ReflectionClass;
use function rmdir;
use function time;
use const true;
use function unlink;
use function var_dump;
use Yii;
use app\models\Car;
use app\models\SearchCar;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
    use ImageTrait;
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Car models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCar();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Car model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Car model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Car();
        $aDeviceTypes = $this->device_types_distribution();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $devicesIds = Yii::$app->request->post('devices');
            if ($devicesIds) {
                $this->car_add_devices($model, [], $devicesIds);
            }
            $images = UploadedFile::getInstances($model, 'images');
            $path = "uploads/car/{$model->id}/";
            if (!$images) {
                $imagePath = 'uploads/no-image.png';
                $images[] = new UploadedFile(['tempName' => $imagePath, 'name' => basename($imagePath)]);
            }
            foreach ($images as $key => $image) {
                $filename_small = md5($model->id) . "{$key}_" . Image::SMALL . '.' . $image->extension;
                $this->thumbs_image($image->tempName, $path . 'thumbs/', $filename_small, 146, 106);
                $model->link('smallImage', $small_image = new Image([
                    'name' => $filename_small,
                    'size' => Image::SMALL,
                    'object_type' => 'car'
                ]));
                $filename_large = md5($model->id) . "{$key}_" . Image::LARGE . '.' . $image->extension;
                $this->thumbs_image($image->tempName, $path . 'thumbs/', $filename_large, 720, 540);
                $model->link('smallImage', $large_image = new Image([
                    'name' => $filename_large,
                    'size' => Image::LARGE,
                    'object_type' => 'car'
                ]));
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'types' => [],
            'aDeviceTypes' => $aDeviceTypes
        ]);
    }

    /**
     * Updates an existing Car model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = Car::find()->where(['id' => $id])->with('devices')->limit(1)->one();
        $aDeviceTypes = $this->device_types_distribution();
        $aOldDevicesIds = ArrayHelper::map($model->devices, 'id', 'id');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->car_add_devices($model, $aOldDevicesIds, Yii::$app->request->post('devices'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'types' => Type::find()->where(['brand_id' => $model->brand_id])->all(),
            'aDeviceTypes' => $aDeviceTypes
        ]);
    }

    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $oModel = Car::find()->where(['id' => $id])->with('allImages')->one();
        $oModel->unlinkAll('devices',true);
        foreach ($oModel->allImages as $oImage) {
            $oImage->delete();
        }
        self::delTree('uploads/car/' .  $oModel->id . '/');
        $oModel->delete();

        return $this->redirect(['index']);
    }

    public function actionTypes()
    {
        $id = Yii::$app->request->post('id');
        $types = Type::find()->where(['brand_id' => $id])->asArray()->all();
        $response = "<option value>Выберите модель авто</option>";
        if (!empty($types)) {
            foreach ($types as $type) {
                $response .= '<option value=\'' . $type['id'] . '\'>' . $type['name'] . '</option>';
            }
        }
        return $response;
    }

    /**
     * Finds the Car model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected static function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    protected function device_types_distribution()
    {
        $aDeviceTypes = [];
        $aDevices = Device::find()->with('deviceType')->asArray()->all();
        foreach ($aDevices as $oDevice) {
            $aDeviceTypes[$oDevice['deviceType']['title']][] = $oDevice;
        }
        return $aDeviceTypes;
    }

    private function car_add_devices(Car $oModel, array $aOldDevicesIds, array $aNewDevicesIds)
    {
        $aNewDevicesIds = Yii::$app->request->post('devices');
        $ids_to_delete = array_diff($aOldDevicesIds, $aNewDevicesIds);
        $ids_to_add = array_diff($aNewDevicesIds, $aOldDevicesIds);
        if ($ids_to_add) {
            foreach (Device::findAll(['id' => $ids_to_add]) as $oDevice) {
                $oModel->link('devices', $oDevice);
            }
        }
        if ($ids_to_delete) {
            foreach (Device::findAll(['id' => $ids_to_delete]) as $oDevice) {
                $oModel->unlink('devices', $oDevice, true);
            }
        }
    }

    /*public function car_add_image(Car $oModel, string $image_path,  $size, $width, $height)
    {
        $this->thumbs_image($image_path, str_replace('full', 'thumbs', $image_path), $width, $height);
        $large_image = new Image([
            'name' => pathinfo($image_path, PATHINFO_FILENAME ),
            'size' => $size,
            'object_id' => $oModel->id,
            'object_type' => (new ReflectionClass($oModel))->getShortName()
        ]);
        $large_image->save(false);
    }*/
}
