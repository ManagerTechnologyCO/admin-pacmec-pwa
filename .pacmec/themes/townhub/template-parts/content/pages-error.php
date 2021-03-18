<div class="content">
    <!--  section  -->
    <section class="parallax-section small-par" data-scrollax-parent="true">
        <div class="bg"  data-bg="images/bg/hero/1.jpg" data-scrollax="properties: { translateY: '30%' }"></div>
        <div class="overlay op7"></div>
        <div class="container">
            <div class="error-wrap">
                <div class="bubbles">
                    <h2>
                      <?php
                      switch (pageinfo("id")) {
                        case -1:
                          echo "404";
                          break;
                        default:
                          echo "9999";
                          break;
                      }
                      ?>
                    </h2>
                </div>
                <p><?= pageinfo("title"); ?></p>
                <div class="clearfix"></div>
                <form action="#">
                    <input name="se" id="se" type="text" class="search" placeholder="Search.." value="Search...">
                    <button class="search-submit color-bg" id="submit_btn"><i class="fal fa-search"></i> </button>
                </form>
                <div class="clearfix"></div>
                <p>Or</p>
                <a href="index.html" class="btn   color2-bg">Back to Home Page<i class="far fa-home-alt"></i></a>
            </div>
        </div>
    </section>
</div>
