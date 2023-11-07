<?php defined('BASEPATH') OR exit('No direct script access allowed');  ?>

<div class="content_footer" id="contact">
    <div class="row footerwrap">
        <div class="col-md-12 contact">
            <div class="contactwrap">
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Customs Excise And Service Tax<br />Appellate Tribunal
                        (CESTAT),<br />
                        West Block 2,
                        1st and 2nd Floor,<br />
                        R.K.Puram,
                        NEW DELHI-110066</li>
                    <li><i class="fas fa-phone"></i> 011-20863312 [MON-FRI 9.30 AM to 6 PM]
				<br /><br /><i class="fas fa-envelope"></i> cestatcomputer[at]gmail[dot]com</li> 
					<li>
						<!--object type="text/html"
							data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3504.1161408138682!2d77.17875231508108!3d28.566274982444!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d1d9b89f38451%3A0x287fec7a26c82807!2sCustoms%20Excise%20And%20Service%20Tax%20Appellate%20Tribunal!5e0!3m2!1sen!2sin!4v1685105438177!5m2!1sen!2sin"></object--> 
</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="flinks">
                <ul>
                    <li><a href="#">Web Policies</a> <span>|</span></li>
                    <li><a href="#">Terms of Use</a> <span>|</span></li>
                    <li><a href="#">Screen Reader</a> <span>|</span></li>
                    <li class="open-menu"><a href="">Useful Links <i class="fa fa-chevron-up"></i></a>
                        <ul class="submenu">
                            <li><a href="https://main.sci.gov.in/" target="_blank">Supreme Court of India</a></li>
                            <li><a href="https://www.allahabadhighcourt.in/" target="_blank">Uttar Pradesh High
                                    Court</a></li>
                            <li><a href="https://www.up-rera.in/" target="_blank">Uttar Pradesh Real Estate
                                    Authority</a></li>
                            <li><a href="https://up.gov.in/" target="_blank">Uttar Pradesh Government Portal</a></li>
                            <li><a href="http://courtcases.up.nic.in/" target="_blank">Uttar Pradesh Court Case
                                    Information System</a></li>
                            <li><a href="https://nclt.gov.in/" target="_blank">National Company Law Tribunal</a></li>
                            <li><a href="https://www.nclat.gov.in/" target="_blank">National Company Law Appellate
                                    Tribunal</a></li>
                            <li><a href="http://ncdrc.nic.in/" target="_blank">National Consumer Dispute Redressal
                                    Commission</a></li>
                        </ul>
                    </li>
                </ul>
                <div style="padding: 8px 0;">Copyright &copy; <?php echo date('Y'); ?>. All Rights Reserved.</div>
                <div class="social-icon mob">
                    <a title=" twitter" target="_blank" href="#"><i class="fab fa-twitter"></i></a>
                    <a title=" Facebook" target="_blank" href="#"><i class="fab fa-facebook"></i></a>
                    <a title=" Linkedin" target="_blank" href="#"><i class="fab fa-linkedin"></i></a>
                    <a title="instagram" target="_blank" href="#"><i class="fab fa-instagram"></i></a>
                    <a title="Youtube" target="_blank" href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
<!-- <div class="copyright">Copyright &copy; <?php echo date('Y'); ?>. All Rights Reserved.</div> -->



<script src="<?= base_url('asset/admin_js_final/jquery.min.js'); ?>"></script>
<script src="<?= base_url('asset/APTEL_files/bootstrap.min.js'); ?>"></script>
<script src="<?= base_url('asset/APTEL_files/owl.carousel.js'); ?>"></script>
<script src="<?= base_url('asset/APTEL_files/jquery-confirm.js');?>"></script>
<script src="<?= base_url('asset/APTEL_files/hash.js'); ?>"></script>
<script src="<?=base_url('asset/admin_js_final/crypto-js.js')?>"></script>
<script src="<?= base_url('asset/APTEL_files/comman.js'); ?>"></script>
<script src="<?= base_url('asset/APTEL_files/lightslider.js'); ?>"></script>


<script type="text/javascript">
var base_url = '',
    _CSRF_NAME_ = '';
base_url = '<?php echo base_url(); ?>';
_CSRF_NAME_ = '<?=$this->security->get_csrf_token_name()?>';
</script>


<script type="text/javascript">
$(document).ready(function() {
    $("#lightSlider").lightSlider({
        item: 1,
        autoWidth: false,
        slideMove: 1, // slidemove will be 1 if loop is true
        slideMargin: 0,

        addClass: '',
        mode: "fade",
        useCSS: true,
        cssEasing: 'ease', //'cubic-bezier(0.25, 0, 0.25, 1)',//
        easing: 'linear', //'for jquery animation',////

        speed: 1000, //ms'
        auto: true,
        loop: true,
        slideEndAnimation: false,
        pause: 5000,

        keyPress: false,
        controls: true,
        prevHtml: '',
        nextHtml: '',

        rtl: false,
        adaptiveHeight: false,

        vertical: false,
        verticalHeight: 500,
        vThumbWidth: 100,

        thumbItem: 10,
        pager: false,
        gallery: false,
        galleryMargin: 5,
        thumbMargin: 5,
        currentPagerPosition: 'middle',

        enableTouch: true,
        enableDrag: true,
        freeMove: true,
        swipeThreshold: 40,

        responsive: [],

        onBeforeStart: function(el) {},
        onSliderLoad: function(el) {},
        onBeforeSlide: function(el) {},
        onAfterSlide: function(el) {},
        onBeforeNextSlide: function(el) {},
        onBeforePrevSlide: function(el) {}
    });
});
</script>
</body>

</html>