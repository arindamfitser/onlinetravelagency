<footer>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <?php if(Request::segment(1)!='users' && Request::segment(1)!='customer' && Request::segment(1)!='hoteliar'){ ?>
                <div class="sosal-box2">
                    <?php
                    $facebook_link = get_option('facebook_link');
                    $instagram_link = get_option('instagram_link');
                    $pinterest_link = get_option('pinterest_link');
                    ?>
                    <?php
                    if($facebook_link != ""){
                    ?>
                    <a href="<?php echo $facebook_link; ?>" target="_blank" ><i aria-hidden="true" class="fa fa-facebook"></i></a>
                    <?php } ?>
                    <?php if($instagram_link != ""){ ?>
                    <a href="<?php echo $instagram_link; ?>" target="_blank" ><i class="fa fa-instagram" aria-hidden="true"></i></a>
                    <?php } ?>
                    <?php if($pinterest_link != ""){ ?>
                    <a href="<?php echo $pinterest_link; ?>" target="_blank" ><i class="fa fa-pinterest-p" aria-hidden="true"></i></a>
                    <?php } ?>
                </div>
                <div class="footernav">
                    <?php echo get_footer_navigation($classes="", $id="");?>
                    <!--<ul>
                        <li><a href="{{URL('why-book-with-us')}}"> Why Book With Us </a></li>
                        <li><a href="{{URL('sustainable-waterways-fund')}}"> Sustainable Waterways Fund </a></li>
                        <li><a href="{{URL('contact')}}"> Contact Us </a></li>
                        <li><a href="{{URL('journal')}}"> Press Releases </a></li>
                        <li><a href="{{URL('partners')}}"> Partners </a></li>
                        <li><a href="{{URL('legal')}}"> Legal </a></li>
                    </ul>-->
                </div>
                <p>By continuing your use of this site you accept the use of cookies in order to provide statistical analysis </p>
                <?php } ?>
                <p>&copy; <?=date('Y')?> <a href="{{URL('')}}">Luxury Fishing.</a> All rights reserved. Website Developed by<a href="https://www.fitser.com/" rel="nofollow" title="Fitser" target="_blank"> Fitser.</a></p>
            </div>
        </div>
    </div>
</footer>
<form id="fromFishingDestinationForm" action="{{route('enroute.search')}}" method="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <input type="hidden" value="" name="region_id">
    <input type="hidden" value="no" name="fromFishing" id="fromFishingDestination">
    <input type="hidden" value="" name="keywords" id="fromFishingKeyword">
    <input type="hidden" value="" name="check_in">
    <input type="hidden" value="" name="check_out">
    <input type="hidden" name="quantity_adults" value="1" />
    <input type="hidden" name="quantity_child" value="0" />
    <input type="hidden" name="num_room" value="1" />
    <input type="hidden" name="noguests" value="1" />
    <input type="hidden" name="ab[norm][]" value="1" />
    <input type="hidden" name="ab[adlts][]" value="1" />
    <input type="hidden" name="ab[kids][]" value="0" /
</form>
<script type="text/javascript">
var searchByKeyword = function(keyword){
    $('#fromFishingKeyword').val(keyword);
    $('#fromFishingDestination').val('yes');
    $('#fromFishingDestinationForm').submit();
}
// var searchByKeyword = function(keyword){
//     $('#fromFishingKeyword').val(keyword);
//     $.ajax({
//         type: "GET",
//         url: "{{route('ajax.get.region')}}",
//         data: {
//             'region' : keyword
//         },
//         beforeSend: function () {
//             $(".divDestinationFishing").loading();
//         },
//         dataType: "json",
//         success: function(json){
//             $('#header_search_region_id').val('');
//             $('#mob_header_search_region_id').val('');
//             if(json.length > 0){
//                 $.each(json, function (key, data) {
//                     $('#header_search_region_id').val(data.region_id);
//                     $('#mob_header_search_region_id').val(data.region_id);
//                 })
//             }
//             $('#fromFishing').val('yes');
//             $('#mobFromFishing').val('yes');
//             $('#hdr_desk_search_btn').click();
//         }
//     });
// }
const onSubmitData = (id, type) => {
    localStorage.setItem("tpid", id);
    $("#data_id").val(id);$("#type").val(type);$("#cat_form").submit()
};
const onSubmitDataAcc = (id, type) => {
    localStorage.setItem("tpid", id);
    $("#acc_data_id").val(id);$("#acc_type").val(type);$("#acc_form").submit()
};
const onSubmitDataInp = (id, type) => {
    localStorage.setItem("tpid", id);
    $("#insp_data_id").val(id);$("#insp_type").val(type);$("#insp_form").submit()
};

</script>