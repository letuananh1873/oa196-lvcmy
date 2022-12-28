

<?php if(get_field('process_steps')): ?>
	<?php $m = 1; ?>
	<div class="process_steps_wrap">
		<?php while(has_sub_field('process_steps')): ?>
			<div class="process_steps process_steps_<?php echo $m; ?>">
				<div class="process_step_img">
					<span class="process_step_num"><?php echo $m; ?></span>
					<img src="<?php the_sub_field('process_step_img'); ?>">
				</div>
				<div class="process_step_textBox">
					<span class="process_step_num"><?php echo $m; ?></span>
					<div class="process_step_textBox_inner">
						<h3><?php the_sub_field('process_step_title'); ?></h3>
						<div><?php the_sub_field('process_step_desc'); ?></div>
						<?php if( get_sub_field('process_show_btn') ): ?>
							<div class="process_step_btn <?php the_sub_field('btn_class_name'); ?>"><a href="<?php the_sub_field('process_step_btn_url'); ?>"><?php the_sub_field('process_step_btn_text'); ?></a></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<?php $m++; ?>
		<?php endwhile; ?>
	</div>
<?php endif; ?>