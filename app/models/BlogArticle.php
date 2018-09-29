<?php
/**
 * Created by PhpStorm.
 * User: liumingyu
 * Date: 2018/9/28
 * Time: 下午5:32
 */
namespace app\models;

use Illuminate\Database\Eloquent\Model;

class BlogArticle extends Model
{

    protected $table = 'blog_article';

    public $timestamps = false;

    public $primaryKey = 'id';

}