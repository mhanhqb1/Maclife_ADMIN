<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3><?php echo !empty($data['post_count']) ? $data['post_count'] : 0;?></h3>

                <p><?php echo __('Bài viết');?></p>
            </div>
            <div class="icon">
                <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo $BASE_URL;?>/posts" class="small-box-footer"><?php echo __('LABEL_MORE_INFO');?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
                <h3><?php echo !empty($data['cate_count']) ? $data['cate_count'] : 0;?></h3>

                <p><?php echo __('Danh mục');?></p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-gear-outline"></i>
            </div>
            <a href="<?php echo $BASE_URL;?>/cates" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3><?php echo !empty($data['tag_count']) ? $data['tag_count'] : 0;?></h3>

                <p><?php echo __('Tag');?></p>
            </div>
            <div class="icon">
                <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo $BASE_URL;?>/tags" class="small-box-footer"><?php echo __('LABEL_MORE_INFO');?> <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<!-- /.row -->
