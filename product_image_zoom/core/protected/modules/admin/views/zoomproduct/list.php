<div class="span9">
	 <h3><?php echo Yii::t('admin','Products.'); ?></h3>
    <div class="editinstructions">
        <div class="span6">
	        <?php echo Yii::t('admin','To upload large image version for product, please select a product and click to edit.'); ?>
        </div>
        <div class="span6">
			<div class="span4 pull-right">
				 <div class="pull-right">
					<span class="label"><?php echo Yii::t('admin','Show '); ?><?php echo $page_size; ?> item(s)</span>
					<select onchange="updateLimit(this.value);" name="limit">
						<option <?php if($page_size==10): ?>selected ="selected"<?php endif; ?> value="10">10</option>
						<option <?php if($page_size==25): ?>selected ="selected"<?php endif; ?> value="25">25</option>
						<option <?php if($page_size==50): ?>selected ="selected"<?php endif; ?> value="50">50</option>
						<option <?php if($page_size==100): ?>selected ="selected"<?php endif; ?> value="100">100</option>
					</select>
				 </div>
			</div>
			<script type="text/javascript">
				function updateLimit(limit){
					var url_submit = '<?php echo $this->createUrl('zoomproduct/list'); ?>?limit='+limit;
					window.location = url_submit;
				}
			</script>
        	<div class="span4 pull-right">
                <div class="clearfix search">
                    <div class="pull-right">
                        <?php echo CHtml::beginForm($this->createUrl('zoomproduct/list'),'get'); ?>
                        <?php echo CHtml::textField('q',Yii::app()->getRequest()->getQuery('q'),array('id'=>'xlsSearch','placeholder'=>'SEARCH PRODUCTS...','submit'=>'')); ?>
                        <?php echo CHtml::endForm(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-view clearfix" id="user-grid">
        <table class="table-bordered table">
            <tr>
                <th id="user-grid_c1" style="span1">ID</th>
                <th id="user-grid_c1" style="span1">Default Image</th>
                <th id="user-grid_c1" style="span1">Large Image</th>
                <th id="user-grid_c1" style="span1">Product Name</th>
                <th id="user-grid_c1" style="span1">Product Code</th>
                <th id="user-grid_c1" style="span1">Action</th>
            </tr>
            <?php if (count($model) > 0): ?>
            <?php foreach($model as $objProduct): ?>
            <tr style="cursor:pointer" onclick="window.location='<?php echo $this->createUrl('zoomproduct/view?pid='.$objProduct->id); ?>';">
                <td class="span1">
					<?php echo $objProduct->id; ?>
                </td>
                <td class="span1"><img src="<?php echo $objProduct->SmallImage; ?>" width="30px;" alt=""/></td>
				<?php
				$rowImg = Yii::app()->db->createCommand()->from('xlsws_mod_zoomproduct')->where('product_id=:product_id', array(':product_id'=>$objProduct->id))->queryRow();
				if($rowImg){
					$imgsrc=Zoomproduct::model()->resizeImage($rowImg['url'],60,60);
				}else{
					$imgsrc=Yii::app()->baseurl.'/images/no_product.png';
				}
				?>
                <td class="span1"><img src="<?php echo $imgsrc; ?>" width="30px;" alt=""/></td>
                <td class="span4">
					<?php echo _xls_truncate($objProduct->Title , 80); ?>
                </td>
                 <td class="span2"><?php echo _xls_truncate($objProduct->Code , 80); ?></td>
                 <td class="span2 pull-center"><a href="<?php echo $this->createUrl('zoomproduct/view?pid='.$objProduct->id); ?>"><?php echo Yii::t('admin','Edit'); ?></a></td>
            </tr>
            <?php endforeach ; ?>
            <?php else: ?>
            <tr>            	
            </tr>
            <?php endif; ?>                    </table>    </div>    
    <div class="clearfix"></div>    <div id="paginator" class="span12 pagination">
        <?php $this->widget('CLinkPager', array(
            'id'=>'pagination',
            'currentPage'=>$pages->getCurrentPage(),
            'itemCount'=>$item_count,
            'pageSize'=>$page_size,
            'maxButtonCount'=>5,
            'firstPageLabel'=> '<< '.Yii::t('global','First'),
            'lastPageLabel'=> Yii::t('global','Last').' >>',
            'prevPageLabel'=> '< '.Yii::t('global','Previous'),
            'nextPageLabel'=> Yii::t('global','Next').' >',
            'header'=>'',
            'htmlOptions'=>array('class'=>'pagination'),
            )); ?>
    </div>
    <div class="clearfix"></div>
</div>