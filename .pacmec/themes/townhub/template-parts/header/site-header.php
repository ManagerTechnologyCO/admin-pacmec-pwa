<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Themes
 * @category   Townhub
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 */
?>
<header class="main-header" v-if="definition!==null">
	<?= (siteinfo('site_logo') !== 'NaN') ? "<a href=\"".siteinfo('siteurl')."\" class=\"logo-holder\"><img src=\"".siteinfo('site_logo')."\" /></a>" : siteinfo('sitename'); ?>
	<!--//<div class="header-search_btn show-search-button"><i class="fal fa-search"></i><span>Search</span></div>-->
  <?php if(isUser()): ?>
	<a href="/me/wallets" class="add-list color-bg">
		<?= _autoT('add_balance'); ?>
		<span><i class="fal fa-layer-plus"></i></span>
	</a>
	<div id="notifications" class="cart-btn show-header-modal" data-microtip-position="bottom" role="tooltip" aria-label="<?= _autoT('user_notifications'); ?>">
		<i class="fal fa-bell"></i><span class="cart-counter orange-bg">{{notifications.length}}</span>
	</div>
	<div class="header-user-menu">
		<div class="header-user-name">
			<!-- // <span><img src="/townhub/images/avatar/1.jpg" alt=""></span> -->
      <?= _autoT('me_label'); ?>
		</div>
    <?= do_shortcode('[pacmec-ul-no-list-style menu_slug="me_profile"][/pacmec-ul-no-list-style]'); ?>
	</div>
<?php else: ?>
	<div class="show-reg-form modal-open avatar-img" data-srcav="/townhub/images/avatar/3.jpg"><i class="fal fa-user"></i> <?= _autoT('signin'); ?> </div>
<?php endif; ?>
<?php if(!empty($GLOBALS['PACMEC']['glossary'])): ?>
	<div class="lang-wrap">
		<!--//<div class="show-lang"><span><i class="fal fa-globe-europe"></i><strong>{{_autoT('change_lang')}}</strong></span><i class="fa fa-caret-down arrlan"></i></div>-->
		<div class="show-lang">
			<span><i class="fal fa-globe-europe"></i><strong><?= $GLOBALS['PACMEC']['lang']; ?> </strong></span>
			<i class="fa fa-caret-down arrlan"></i>
		</div>
		<ul class="lang-tooltip lang-action no-list-style">
			<?php foreach ($GLOBALS['PACMEC']['glossary'] as $b => $a): ?>
				<li>
					<a href="#" onclick="javascript:insertParam('lang', '<?= $b; ?>')" style="cursor:pointer;" class="<?= ($GLOBALS['PACMEC']['lang'] == $b) ? 'current-lan' : ''; ?>" data-lantext="<?= $b; ?>">
							<?= $a['name']; ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php endif; ?>
	<div class="nav-button-wrap color-bg">
		<div class="nav-button">
			<span></span><span></span><span></span>
		</div>
	</div>
	<div class="nav-holder main-menu">
    <?= do_shortcode('[pacmec-nav-top-menu class="no-list-style" menu_slug="primary"][/pacmec-nav-top-menu]'); ?>
	</div>
	<div class="header-modal novis_wishlist">
		<div class="header-modal-container scrollbar-inner fl-wrap" data-simplebar>
			<div class="widget-posts  fl-wrap">
      <?php
			/*
      if($notifications !== null): ?>
				<ul class="no-list-style">
					<li v-for="(notification, notification_i) in notifications" :id="'notification-gen-'+notification.id">
						<div v-if="notification.thumb !== null" class="widget-posts-img"><a :href="notification.link"><img :src="notification.thumb" alt=""></a></div>
						<div class="widget-posts-descr">
							<h4><a :href="notification.link">{{ (notification.title !== null) ? notification.title : '' }}{{ (notification.subtitle !== null) ? ' - ' + notification.subtitle : '' }}</a></h4>
							<div class="geodir-category-location fl-wrap">
								<a :href="notification.link">
									<i v-if="notification.icon !== null" :class="notification.icon"></i>
									{{ notification.content }}
								</a>
							</div>
							<div class="widget-posts-descr-link">
								<a>{{ notification.date }}</a>
							</div>
							<div v-if="notification.score !== null" class="widget-posts-descr-score">{{ notification.score }}</div>
							<div @click="readPush(notification.id)" class="clear-wishlist"><i class="fal fa-times-circle"></i></div>
						</div>
					</li>
				</ul>
      <?php endif;
      */ ?>
			</div>
		</div>
		<div class="header-modal-top fl-wrap">
			<h4><?= _autoT('user_notifications'); ?> : <span><strong></strong> <?= _autoT('user_notifications_label_count'); ?> </span></h4>
			<div class="close-header-modal"><i class="far fa-times"></i></div>
		</div>
	</div>
</header>
