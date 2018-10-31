<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/29
 * Time: 下午3:10
 */

namespace services\ted;

class View
{
    const VIEW_BASE_PATH = '/' .APP_NAME. '/views/';

    public $view;
    public $data = [];
    public $_layout_data = [];
    public $_block = [];

    public function __construct($view = null)
    {
        $this->view = $view;
    }

    /**
     * 获取视图路径
     * @param null $viewName
     * @return View
     */
    public static function make($viewName = null)
    {
        if ( ! $viewName ) {
            throw new \InvalidArgumentException("视图名称不能为空！");
        } else {

            $viewFilePath = self::getFilePath($viewName);
            if ( is_file($viewFilePath) ) {
                return new View($viewFilePath);
            } else {
                throw new \UnexpectedValueException($viewFilePath." 视图文件不存在！");
            }
        }
    }

    /**
     * 绑定参数
     * @param $key
     * @param null $value
     * @return $this
     */
    public function with($key, $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * 设置传递数据
     * @param array $data
     * @return $this
     */
    public function setData($data = []){

        foreach ($data as $_k=>$_v){
            $this->with($_k, $_v);
        }

        return $this;
    }

    /**
     * 获取文件路径
     * @param $viewName
     * @return string
     */
    private static function getFilePath($viewName)
    {
        $filePath = str_replace('.', '/', $viewName);
        return BASE_PATH.self::VIEW_BASE_PATH.$filePath.'.php';
    }

    /**
     * Renders a view file as a PHP script.  引用Yii2
     *
     * This method treats the view file as a PHP script and includes the file.
     * It extracts the given parameters and makes them available in the view file.
     * The method captures the output of the included view file and returns it as a string.
     *
     * This method should mainly be called by view renderer or [[renderFile()]].
     *
     * @param string $_file_ the view file.
     * @param array $_params_ the parameters (name-value pairs) that will be extracted and made available in the view file.
     * @return string the rendering result
     * @throws \Exception
     * @throws \Throwable
     */
    private function renderPhpFile($_file_, $_params_ = [])
    {
        $_obInitialLevel_ = ob_get_level();
        ob_start();
        ob_implicit_flush(false);
        extract($_params_, EXTR_OVERWRITE);
        try {
            require $_file_;
            return ob_get_clean();
        } catch (\Exception $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        } catch (\Throwable $e) {
            while (ob_get_level() > $_obInitialLevel_) {
                if (!@ob_end_clean()) {
                    ob_clean();
                }
            }
            throw $e;
        }
    }

    /**
     * 渲染视图 【渲染布局】
     * @param $viewName
     * @param array $data
     * @param $layout
     * @return mixed
     */
    public function render($viewName, $data = [], $layout){

        // 渲染模版
        $content = View::make($viewName)->setData($data);
        $output = $this->renderPhpFile($content->view, $content->data);

        // 渲染layout
        if(!empty($layout)){
            $this->_layout_data = $content->data;
            $content = View::make($layout)->setData(['content'=>$output]);
            $output = $this->renderPhpFile($content->view, $content->data);
        }

        return $output;

    }

    /**
     * 渲染视图 【不渲染布局】
     * @param $viewName
     * @param array $data
     * @return mixed
     */
    public function renderPartial($viewName, $data = []){

        // 渲染模版
        $content = View::make($viewName)->setData($data);
        return $this->renderPhpFile($content->view, $content->data);
    }

    /**
     * 引入View 文件 未使用 仅做学习参考
     * 备注：同 renderPhpFile() 方法类似
     * @return mixed
     */
    public function requireView(){
        $view = $this->view;

        // instanceof 作用：（1）判断一个对象是否是某个类的实例，（2）判断一个对象是否实现了某个接口。
        if ( $view instanceof View ) {

            // extract — 从数组中将变量导入到当前的符号表
            // 例如 extract(['color'=>'blue','age'=>18,'gender'=>'man'])
            // echo "$color, $age, $gender"

            extract($view->data);

            // 引用视图文件
            return require $view->view;
        }
    }

    /**
     * 获取指定区域块内容 【开始】
     * @param $id
     */
    public function beginBlock($id)
    {
        ob_start();
        ob_implicit_flush(false);
    }

    /**
     * 获取指定区域块内容 【结束】
     * @param $id
     */
    public function endBlock($id)
    {
        $this->_block[$id] = ob_get_clean();
    }

    /**
     * 当调用类中不存在的方法时，就会调用__call();  魔术方法
     * @param $method
     * @param $parameters
     * @return View
     */
    public function __call($method, $parameters)
    {
        if (starts_with($method, 'with'))
        {
            return $this->with(snake_case(substr($method, 4)), $parameters[0]);
        }

        throw new \BadMethodCallException("方法 [$method] 不存在！.");
    }
}