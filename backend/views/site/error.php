<?php
/**
 * yiiplus/scaffold
 *
 * @category  PHP
 * @package   Yii2
 * @copyright 2018-2019 YiiPlus Ltd
 * @license   https://github.com/yiiplus/scaffold/licence.txt Apache 2.0
 * @link      http://www.yiiplus.com
 */
 
    use yii\helpers\Html;

    $this->title = $name;
?>
<section class="content">

    <div class="error-page">
        <h2 class="headline text-info"><i class="fa fa-warning text-yellow"></i></h2>

        <div class="error-content">
            <h3><?php echo $name; ?></h3>

            <p>
                <?php echo nl2br(Html::encode($message)); ?>
            </p>

            <p>
                The above error occurred while the Web server was processing your request.
                Please contact us if you think this is a server error. Thank you.
                Meanwhile, you may <a href='<?php echo Yii::$app->homeUrl; ?>'>return to dashboard</a> or try using the search
                form.
            </p>

            <form class='search-form'>
                <div class='input-group'>
                    <input type="text" name="search" class='form-control' placeholder="Search"/>

                    <div class="input-group-btn">
                        <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</section>
