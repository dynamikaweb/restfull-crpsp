<?php
namespace frontend\controllers;

use Yii;

use yii\helpers\ArrayHelper;
use yii\web\HttpException;

/**
 * API Controller 
 * 
 * *
 * 
 * Consulta de dados do site
 * 
 * *
 * 
 * @version 1.0 (12/09/2019) => primeira versão funcional
 * @version 2.0 (08/11/2019) => suporte de arquivos
 * @author Rodrigo Dornelles <rodrigo@dornelles.me> <rodrigo@dynamika.com.br>
 * 
 * *
 * 
 * @throws Http 400 Bad Request
 * @throws Http 403 Forbiden
 * @throws Http 404 Not Found
 * 
 * *
 * 
 * @example     
 *   "name":"Status"
 *   "message":"API está funcionando!"
 *   "code":1
 *   "status":200
 *   "type": "yii\\web\\Application"    
 */

class ApiController extends SiteBaseController
{
    /**
     * @property MODULOS
     * 
     * Modulos autorizados a serem consumidos pela @api
     * 
     */
    const MODULOS = [
        'noticia',
        'banner',
        'comissao',
        'concurso',
        'edital',
        'especial',
        'evento',
        'faq',
        'impresso',
        'midia',
        'materia',
        'pagina',
        'sede'
    ];

    /**
     * beforeAction
     * 
     * antes da acton ser chamada
     *
     * @param  object $action
     *
     * @return boolean run action
     */
    public function beforeAction($action)
    {
        // Formato de saida sera em json
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        // Verificar autorização do modulo
        if( $modulo = Yii::$app->request->get('modulo') ){
            self::can($modulo);
        }

        return parent::beforeAction($action); 
    }


    /**
     * actionIndex 
     *
     * estado de funcionamento da api
     * 
     * @return array @api
     */
    public function actionIndex()
    {        
        return $this->json( true, [
            'name' => 'Status',
            'message' => 'API está funcionando!'
        ]);
    }

    /**
     * actionView
     * 
     * Visualizar Registros do modulo
     *
     * @param  string $modulo 
     *
     * @return array @api
     */
    public function actionView($modulo)
    {
        // ActiveDataProvider Search
        $dataProvider = $this->findModels($modulo);
        $models = $dataProvider->getModels();
        $count = $dataProvider->getCount();

        // Verifica foi encontrado registros
        if($count == 0){
            throw new HttpException(404,'Nenhum registro foi encontrado!');
        }

        // Output
        return $this->json($models, ['count' => $count]);
    }

    /**
     * actionFile
     * 
     * retorna array de links para arquivos
     *
     * @param  string $modulo => modulo a ser consultado
     * @param  integer $id => identificador do documento
     * @param  string $size => tamanho das imagens
     * 
     * @return void
     */
    public function actionFiles($modulo, $id, $size = 'thumb_')
    {
        $dataProvider = $this->findModels($modulo);
        $models = $dataProvider->getModels();
        $count = $dataProvider->getCount();

        // Verifica foi encontrado registros
        if($count == 0){
            throw new HttpException(404,'Nenhum registro foi encontrado!');
        }

        $model = array_shift($models);
        $arquivos = array();

        // Arquivo unico
        if($model->canGetProperty('arquivo')){
            $arquivo = $model->arquivo;
            $prefix = $arquivo->tipo == $arquivo::TIPO_IMAGEM ? $size:''; //Prefixo tamanho da imagem
            $arquivos []= $arquivo->getFileUrl($modulo, $prefix);
        }

        // Arquivos Multiplos
        if($model->canGetProperty('arquivos'))
        {
            foreach($model->arquivos as $arquivo){
                $prefix = $arquivo->tipo == $arquivo::TIPO_IMAGEM ? $size:''; //Prefixo tamanho da imagem
                $arquivos []= $arquivo->getFileUrl($modulo, $prefix);
            }
        }

        // Contar arquivos
        $count = count($arquivos);


        // Verifica foi encontrado registros
        if($count == 0){
            throw new HttpException(404,'Nenhum arquivo foi encontrado!');
        }

        
        return $this->json($arquivos, ['count' => $count]);
    }



    /**
     * findModels
     * 
     * encontra os registros de acordo com o modulo
     *
     * @param  string $modulo Modulo
     *
     * @return object data provider
     */
    private function findModels($modulo)
    {
        // Classe {modulo}Search 
        $modulo = '\common\models\search\\'.ucfirst($modulo).'Search';        
        
        // Filters SearchModel
        $searchModel = new $modulo;
        $searchModel->pageSize = Yii::$app->request->get('limit', 1);
        $searchModel->id = Yii::$app->request->get('id', null);
        
        // ActiveDataProvider Search
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $dataProvider;
    }

    /**
     * json
     * 
     * formata array para padrão de saida da @api
     *
     * @param  mixed $data dados para ser consumidos pela @api
     * @param  mixed $params parametros de resposta personalizado
     *
     * @return array saida da @api
     */
    private function json($data, $params = [])
    {
        // parametros de resposta
        $default = [
            'name' => ucfirst(Yii::$app->controller->action->id),
            'message' => 'Concluído com sucesso!',
            'code' => 1,
            'status' => 200,
            'type' => 'yii\\web\\Application',
            'data' => $data            
        ];

        // parametros personalizados sobrepoem os padrões
        return ArrayHelper::merge($default, $params);
    }


    /**
     * can
     * 
     * verifica se o modulo está disponivel para utilização
     *
     * @param  string $modulo
     * @throws HttpException 403 Não autorizado, se não for possivel encontrar o modulo.
     *
     * @return void 
     */
    private static function can($modulo)
    {
        if( array_search($modulo, self::MODULOS) === false ){
            throw new HttpException(403, 'Não autorizado!');
        }
    }

} 
