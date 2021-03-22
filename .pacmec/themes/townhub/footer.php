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
          <footer class="main-footer fl-wrap">
              <!-- footer-header-->
              <div class="footer-header fl-wrap grad ient-dark">
                  <div class="container">
                      <div class="row">
                          <div class="col-md-5">
                              <div  class="subscribe-header">
                                  <h3><?= _autoT('subscribe_newsletter_title')?></h3>
                                  <p><?= _autoT('subscribe_newsletter_content')?></p>
                              </div>
                          </div>
                          <div class="col-md-7">
                              <div class="subscribe-widget">
                                  <div class="subcribe-form">
                                      <form id="subscribe">
                                          <input class="enteremail fl-wrap" name="email" id="subscribe-email" placeholder="Enter Your Email" spellcheck="false" type="text">
                                          <button alt="<?= _autoT('subscribe_newsletter_title')?>" title="<?= _autoT('subscribe_newsletter_title')?>" type="submit" id="subscribe-button" class="subscribe-button"><i class="fal fa-envelope"></i></button>
                                          <label for="subscribe-email" class="subscribe-message"></label>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <!-- footer-header end-->
              <!--footer-inner-->
              <div class="footer-inner   fl-wrap">
                  <div class="container">
                      <div class="row">
                          <!-- footer-widget-->
                          <div class="col-md-4">
                              <div class="footer-widget fl-wrap">
                                  <div class="footer-logo"><a href="index.html"><img src="images/logo.png" alt=""></a></div>
                                  <div class="footer-contacts-widget fl-wrap">
                                      <p>In ut odio libero, at vulputate urna. Nulla tristique mi a massa convallis cursus. Nulla eu mi magna. Etiam suscipit commodo gravida.   </p>
                                      <ul  class="footer-contacts fl-wrap no-list-style">
                                          <li><span><i class="fal fa-envelope"></i> Mail :</span><a href="#" target="_blank">yourmail@domain.com</a></li>
                                          <li> <span><i class="fal fa-map-marker"></i> Adress :</span><a href="#" target="_blank">USA 27TH Brooklyn NY</a></li>
                                          <li><span><i class="fal fa-phone"></i> Phone :</span><a href="#">+7(111)123456789</a></li>
                                      </ul>
                                      <div class="footer-social">
                                          <span>Find  us on: </span>
                                          <ul class="no-list-style">
                                              <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                              <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                                              <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                                              <li><a href="#" target="_blank"><i class="fab fa-vk"></i></a></li>
                                              <li><a href="#" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <!-- footer-widget end-->
                          <!-- footer-widget-->
                          <div class="col-md-4">
                              <div class="footer-widget fl-wrap">
                                  <h3>Our Last News</h3>
                                  <div class="footer-widget-posts fl-wrap">
                                      <ul class="no-list-style">
                                          <li class="clearfix">
                                              <a href="#"  class="widget-posts-img"><img src="images/all/1.jpg" class="respimg" alt=""></a>
                                              <div class="widget-posts-descr">
                                                  <a href="#" title="">Vivamus dapibus rutrum</a>
                                                  <span class="widget-posts-date"><i class="fal fa-calendar"></i> 21 Mar 09.05 </span>
                                              </div>
                                          </li>
                                          <li class="clearfix">
                                              <a href="#"  class="widget-posts-img"><img src="images/all/1.jpg" class="respimg" alt=""></a>
                                              <div class="widget-posts-descr">
                                                  <a href="#" title=""> In hac habitasse platea</a>
                                                  <span class="widget-posts-date"><i class="fal fa-calendar"></i> 7 Mar 18.21 </span>
                                              </div>
                                          </li>
                                          <li class="clearfix">
                                              <a href="#"  class="widget-posts-img"><img src="images/all/1.jpg" class="respimg" alt=""></a>
                                              <div class="widget-posts-descr">
                                                  <a href="#" title="">Tortor tempor in porta</a>
                                                  <span class="widget-posts-date"><i class="fal fa-calendar"></i> 7 Mar 16.42 </span>
                                              </div>
                                          </li>
                                      </ul>
                                      <a href="blog.html" class="footer-link">Read all <i class="fal fa-long-arrow-right"></i></a>
                                  </div>
                              </div>
                          </div>
                          <!-- footer-widget end-->
                          <!-- footer-widget  -->
                          <div class="col-md-4">
                              <div class="footer-widget fl-wrap ">
                                  <h3>Our  Twitter</h3>
                                  <div class="twitter-holder fl-wrap scrollbar-inner2" data-simplebar data-simplebar-auto-hide="false">
                                      <div id="footer-twiit"></div>
                                  </div>
                                  <a href="#" class="footer-link twitter-link" target="_blank">Follow us <i class="fal fa-long-arrow-right"></i></a>
                              </div>
                          </div>
                          <!-- footer-widget end-->
                      </div>
                  </div>
                  <!-- footer bg-->
                  <div class="footer-bg" data-ran="4"></div>
                  <div class="footer-wave">
                      <svg viewbox="0 0 100 25">
                          <path fill="#fff" d="M0 30 V12 Q30 17 55 12 T100 11 V30z" />
                      </svg>
                  </div>
                  <!-- footer bg  end-->
              </div>
              <!--footer-inner end -->
              <!--sub-footer-->
              <div class="sub-footer  fl-wrap">
                  <div class="container">
                      <div class="copyright"> &#169; Townhub 2019 .  All rights reserved.</div>




                      <?php if(!empty($GLOBALS['PACMEC']['glossary'])): ?>
                    	<div class="lang-wrap">
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

                      <div class="subfooter-nav">
                          <ul class="no-list-style">
                              <li><a href="#">Terms of use</a></li>
                              <li><a href="#">Privacy Policy</a></li>
                              <li><a href="#">Blog</a></li>
                          </ul>
                      </div>
                  </div>
              </div>
              <!--sub-footer end -->
          </footer>
          <!--footer end -->
          <?php get_template_part("template-parts/modals/register"); ?>
          <!--register form end -->
          <a class="to-top"><i class="fas fa-caret-up"></i></a>

        </div>
        <?php pacmec_foot(); ?>
    </body>
</html>
