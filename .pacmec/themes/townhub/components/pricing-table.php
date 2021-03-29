<?php
/**
 *
 * @author     FelipheGomez <feliphegomez@gmail.com>
 * @package    Townhub
 * @category   Themes
 * @copyright  2020-2021 Manager Technology CO
 * @version    1.0.1
 *
 */
$amount = new \NumberFormatter( infosite('site_format_currency'), \NumberFormatter::CURRENCY );
?>
<style>
.price-num-item {
  font-size: 39px;
}
</style>
<section   id="sec1" data-scrollax-parent="true">
    <div class="container">
        <div class="section-title">
            <?php if($title !== null) echo "<h2>"._autoT($title)."</h2>"; ?>
            <?php if($subtitle !== null) echo "<div class=\"section-subtitle\">"._autoT($subtitle)."</div>"; ?>
            <span class="section-separator"></span>
            <?php if($content !== null) echo "<p>"._autoT($content)."</p>"; ?>
        </div>
        <div class="pricing-switcher">
            <div class="fieldset color-bg">
                <input type="radio" name="duration-1"  id="monthly-1" class="tariff-toggle" checked>
                <label for="monthly-1"><?= _autoT('Night'); ?></label>
                <!--//
                  <input type="radio" name="duration-1" class="tariff-toggle"  id="yearly-1">
                  <label for="yearly-1">Yearly Tariff</label>
                  <span class="switch"></span>
                -->
            </div>
        </div>
        <div class="pricing-wrap fl-wrap">
          <?php if($steps !== null): ?>
            <?php foreach($steps As $step_i => $step): ?>
              <div class="price-item">
                  <div class="price-head  purp-gradient-bg">
                      <h3><?= _autoT($step->label); ?></h3>
                      <div class="price-num col-dec-1 fl-wrap">
                          <div class="price-num-item">
                            <span class="mouth-cont"><span class="curen"></span><?= $amount->format( $step->price ); ?></span>
                            <span class="year-cont"><span class="curen">$</span>530</span>
                          </div>
                          <div class="clearfix"></div>
                          <div class="price-num-desc">
                            <span class="mouth-cont">x <?= _autoT($step->per); ?></span>
                            <span class="year-cont">Per Year</span>
                          </div>
                      </div>
                      <div class="circle-wrap" style="right:20%;top:50px;"  >
                          <div class="circle_bg-bal circle_bg-bal_versmall" data-scrollax="properties: { translateY: '50px' }"></div>
                      </div>
                      <div class="circle-wrap" style="right:75%;top:90px;"  >
                          <div class="circle_bg-bal circle_bg-bal_versmall"></div>
                      </div>
                      <div class="footer-wave">
                          <svg viewbox="0 0 100 25">
                              <path fill="#fff" d="M0 30 V12 Q30 17 55 12 T100 11 V30z" />
                          </svg>
                      </div>
                      <div class="footer-wave footer-wave2">
                          <svg viewbox="0 0 100 25">
                              <path fill="#fff" d="M0 90 V12 Q30 7 45 12 T100 11 V30z" />
                          </svg>
                      </div>
                  </div>
                  <div class="price-content fl-wrap">
                      <div class="price-desc fl-wrap">
                          <ul class="no-list-style">
                            <?php if(isset($step->people)) echo "<li>{$step->people} "._autoT('people')."</li>"; ?>
                          </ul>
                          <!--//<a href="#" class="price-link purp-bg">Choose Professional</a>-->
                      </div>
                  </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>

        </div>
        <span class="section-separator"></span>
        <!-- features-box-container - ->
        <div class="features-box-container fl-wrap">
            <div class="row">
                <div class="col-md-4">
                    <div class="features-box">
                        <div class="time-line-icon">
                            <i class="fal fa-headset"></i>
                        </div>
                        <h3>24 Hours Support</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar.    </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="features-box">
                        <div class="time-line-icon">
                            <i class="fal fa-users-cog"></i>
                        </div>
                        <h3>Admin Panel</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar.   </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="features-box ">
                        <div class="time-line-icon">
                            <i class="fal fa-mobile"></i>
                        </div>
                        <h3>Mobile Friendly</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas in pulvinar neque. Nulla finibus lobortis pulvinar.  </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- features-box-container end  -->
    </div>
</section>
