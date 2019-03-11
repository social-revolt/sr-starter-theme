<?php

$image = get_sub_field('image');

?>

<section>
	<div class="container">
		<div class="row">
			<div class="col-xs">
				<div class="box">
					<img data-aos="fade-in" data-aos-delay="0" data-aos-easing="ease-in-out" src="<?php echo $image; ?>">
				</div>
			</div>
		</div>
	</div>
</section>