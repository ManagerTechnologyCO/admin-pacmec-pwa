<section class="hero-section"   data-scrollax-parent="true">
	<div class="bg-tabs-wrap">
		<div class="bg-parallax-wrap" data-scrollax="properties: { translateY: '200px' }">
      <?php ($pictureBG !== null) ? "<div class=\"bg bg_tabs\"  data-bg=\"{$pictureBG}\"></div>" : ""; ?>
      <?php if($videoActive == true && $videoProvider == 'local'): ?>
        <div class="video-container">
          <video autoplay  loop muted  class="bgvid">
            <source src="<?= $videoID; ?>" type="video/mp4">
          </video>
        </div>
      <?php elseif($videoActive == true && $videoProvider !== 'local'): ?>
        <div class="<?= ($videoProvider=='vimeo' ? 'background-vimeo' : ($videoProvider=='youtube'?'background-youtube-wrapper':'')); ?>" data-vid="<?= $videoID; ?>" data-mv="1"> </div>
      <?php endif; ?>
			<div class="overlay op7"></div>
		</div>
	</div>
	<div class="container small-container">
		<div class="intro-item fl-wrap">
			<span class="section-separator"></span>
			<div class="bubbles" v-if="title !== null">
				<h1><?= _autoT($title); ?></h1>
			</div>
			<h3><?= _autoT($description); ?></h3>
		</div>
    <?php if($enable_search == "true"): ?>
  		<div class="main-search-input-tabs  tabs-act fl-wrap">
        <div class="tabs-container fl-wrap">
          <div class="tab">
            <div id="tab-inpt1" class="tab-content first-tab">
              <div class="main-search-input-wrap fl-wrap">
                <div class="main-search-input fl-wrap">
                  <div class="main-search-input-item" style="width:100%;">
                    <label><i class="fal fa-keyboard"></i></label>
                    <input type="text" placeholder="<?= _autoT('search_placeholder'); ?>" value=""/>
                  </div>
  								<button class="main-search-button color2-bg" type="button">
                      <?= _autoT('search_btn_txt'); ?> <i class="far fa-search"></i>
                  </button>
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
  		</div>
    <?php endif; ?>
		<div class="hero-categories fl-wrap">
      <?php if($subtitle !== null) echo "<h4 class=\"hero-categories_title\">"._autoT($subtitle)."</h4>\n"; ?>
      <?php if($icons !== null) echo do_shortcode("[pacmec-ul-no-list-style target=\"_blank\" menu_slug=\"{$icons}\" iconpro=\"s\" class=\"no-list-style\"][/pacmec-ul-no-list-style]")."\n"; ?>
		</div>
	</div>
	<!--//
	<div class="header-sec-link">
		<a href="#step-1" class="custom-scroll-link"><i class="fal fa-angle-double-down"></i></a>
	</div>
	-->
</section>
