<?php
/**
 * 从 scstat 项目的 UnitController 改名而来。
 */

namespace appsc\controllers;

use Yii;
use appsc\models\Unit;
use appsc\models\UnitSearch;
use appsc\helpers\DropDownHelper;
use appsc\models\BonusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UnitController implements the CRUD actions for Unit model.
 */
class UtController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Unit models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnitSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->query->orderBy(['createdAt' => SORT_DESC]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Unit model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        // return messages on update of record

        // 由于使用了 kartik/detail-view，支持 edit 模式，所以在这里 save()
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Yii::$app->session->setFlash('kv-detail-success', 'Success Message');
        }

        $searchModel = new BonusSearch();
        $searchModel->unitId = $id;
        $dataProvider = $searchModel->search([]);
        
        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView2($id)
    {
        return $this->render('dialog_view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Unit model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 对话框方式被 unit/index 界面上按钮弹出
     */
    public function actionDCreate()
    {
        $model = new Unit();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return 'success';
        }

        return $this->renderAjax('_form', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Unit model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Unit model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $from = null)
    {
        $this->findModel($id)->delete();

        if (empty($from)) {
            return $this->redirect(['index']);
        }else if ($from == 'index'){
            // 在 index action 中的列表中删除，重载列表本身
            return $this->redirect(Yii::$app->request->referrer);
        }        
    }

    /**
     * Finds the Unit model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Unit the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unit::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    // DepDrop 方式查询数据
    public function actionSearch(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $units = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $units = Unit::findAll(['race' => $parents[0]]);            
        }

        return DropDownHelper::makeDepDropQueryResult($units);
    }
}
