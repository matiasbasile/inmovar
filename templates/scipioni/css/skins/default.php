<?php
function addOpacity($c,$opacity) {
  if (strpos($c,"rgba") !== FALSE) return $c; // Ya lo tiene
  $c = str_replace("rgb","rgba",$c);
  return substr($c,0,strrpos($c,")")).",".$opacity.")";
}
function changeBrightness($c,$value) {
  $list = extract_rgb($c);
  if (sizeof($list)!=3) return $c;
  return "rgb(".maxmin($list[0]+$value).",".maxmin($list[1]+$value).",".maxmin($list[2]+$value).")";
}
function addColor($c,$color) {
  $list = extract_rgb($c);
  if (sizeof($list)!=3) return $c;
  if (sizeof($color)!=3) return $c;
  return "rgb(".maxmin($list[0]+$color[0]).",".maxmin($list[1]+$color[1]).",".maxmin($list[2]+$color[2]).")";
}
function maxmin($v) {
  return ($v > 255) ? 255 : (($v < 0) ? 0 : $v);
}
function extract_rgb($c) {
  $c = str_replace("rgba","",$c);
  $c = str_replace("rgbaa","",$c);
  $c = str_replace("rgb","",$c);
  $c = str_replace("(","",$c);
  $c = str_replace(")","",$c);
  return explode(",",$c);
}
?>

a:hover {
    text-decoration: none;
}

#page_scroller {
    background: <?php echo $c1; ?>;

}

.property-content .title a{
    color: <?php echo $c1; ?>;
}

.setting-button{
    background: <?php echo $c1; ?>;
}

.option-panel h2{
    color: <?php echo $c1; ?>;
}

.list-inline-listing .active{
    background: <?php echo $c1; ?>;
}

.list-inline-listing li:hover{
    background: <?php echo $c1; ?>;
}

.counters {
    background: <?php echo $c1; ?>;
}

.checkbox-theme input[type="checkbox"]:checked + label::before {
    border: 2px solid <?php echo $c1; ?>;
}

input[type=checkbox]:checked + label:before {
    color: <?php echo $c1; ?>;
}

.button-theme {
    background: <?php echo $c1; ?>;
    border: 2px solid <?php echo $c1; ?>;
}

.button-theme:hover {
    background: <?php echo changeBrightness($c1,-30) ?>;
    border: 2px solid <?php echo changeBrightness($c1,-30) ?>;
}

.error404-content h1 {
    color: <?php echo $c1; ?>;
}

.footer-top form .button-small {
    border: solid 1px <?php echo $c1; ?>;
    background: <?php echo $c1; ?>;
}

.properties-amenities ul li i {
    color: <?php echo $c1; ?>;
}

.properties-condition ul li i {
    color: <?php echo $c1; ?>;
}

.banner-detail-box h3{
    color: <?php echo $c1; ?>;
}

.border-button-theme {
    border: 2px solid <?php echo $c1; ?>;
    color: <?php echo $c1; ?>;
}

.border-button-theme:hover {
    background: <?php echo $c1; ?>;
    color: #fff !important;
}

.theme-tabs .nav-tabs > li > a {
    background: <?php echo $c1; ?>;
}

.theme-tabs .nav-tabs > li.active > a,
.theme-tabs .nav-tabs > li > a:hover {
    color: <?php echo $c1; ?>; !important;
}

.theme-tabs .nav-tabs > li > a::after {
    background: <?php echo $c1; ?>;
}

.theme-tabs .tab-nav > li > a::after {
    background: <?php echo $c1; ?> none repeat scroll 0% 0%;
}

.rightside-navbar li .button {
    color: <?php echo $c1; ?> !important;
    border: 2px solid <?php echo $c1; ?> !important;
}

.nav .open>a, .nav .open>a:focus, .nav .open>a:hover {
    border-color: <?php echo $c1; ?>;
    border-bottom: transparent;
}


.rightside-navbar li .button:hover {
    background: <?php echo $c1; ?> !important;
}

.search-button {
    background: <?php echo $c1; ?>;

}

.navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:focus,
.navbar-default .navbar-nav > .active > a:hover {
    color: <?php echo $c1; ?> !important;
    border-top: solid 5px <?php echo $c1; ?> !important;
}

.main-header .navbar-default .nav > li > a:hover {
   color: <?php echo $c1; ?>;
    border-top: solid 5px <?php echo $c1; ?>;
}

.intro-section {
    background: <?php echo $c1; ?>;
}
.search-button {
    background: <?php echo $c3 ?>;
}
.search-button:hover {
    color: #fff;
    background: <?php echo changeBrightness($c3,-30) ?>;
}

.panel-box .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    background: <?php echo $c1; ?>;
    color: #fff;
    box-shadow: 2px 2px 4px 2px rgba(0,0,0,0.15);
}

.properties-panel-box .nav-tabs>li>a:hover {
    color: #fff;
    background: <?php echo $c1; ?>;
}

.service-item .detail {
    border-top: solid 3px <?php echo $c1; ?>;
}

.heading-properties p i{
    color: <?php echo $c1; ?>;
    margin-right: 5px;
}

.heading-properties h5{
    color: <?php echo $c1; ?>;
}

.heading-properties h3 span{
    color: <?php echo $c1; ?>;
}

.bootstrap-select.btn-group.show-tick .dropdown-menu li.selected a span.check-mark {
    color: <?php echo $c1; ?>;
}

.bootstrap-select .dropdown-menu li a {
    color: <?php echo $c1; ?>;
}

.bootstrap-select .dropdown-menu li a:hover {
    background: <?php echo $c1; ?>;
}

.bootstrap-select .dropdown-menu > .active > a,
.bootstrap-select .dropdown-menu > .active > a:focus,
.bootstrap-select .dropdown-menu > .active > a:hover {
    color: <?php echo $c1; ?>;
}


.for-sale {
    background: <?php echo $c1; ?>;
}

.our-service .content i {
    background: <?php echo $c1; ?>;
}

.our-service .content h4, .our-service .content h4 a {
    color: <?php echo $c1; ?>;
}

.footer-top .social-list li a:hover{
    background: <?php echo $c1; ?>;
    border: solid 1px <?php echo $c1; ?>;
}

.category-content .btn, .category-content .pricing-btn {
    background: <?php echo $c1; ?>;
}

.agent-box .title a:hover{
    color: <?php echo $c1; ?>;
}

.service-item .icon {
    background: <?php echo $c1; ?>;
}

.service-item .detail h3 {
    color: <?php echo $c1; ?>;
}

.dropdown-menu>li>a:hover {
    color: <?php echo $c1; ?>;
    border-left: solid 5px <?php echo $c1; ?>;
}

.plan.featured .price-header {
    background: <?php echo $c1; ?>;
}

.option-bar .heading-icon{
    background: <?php echo $c1; ?>;
}
.change-view-btn {
    color: <?php echo $c1; ?>;
    border: solid 1px <?php echo $c1; ?>;
}

.agent-box .contact p i {
    color: <?php echo $c1; ?>;
}

.change-view-btn:hover {
    border: solid 1px <?php echo $c1; ?>;
    background: <?php echo $c1; ?>;
}

.active-view-btn {
    background: <?php echo $c1; ?>;
    border: solid 1px <?php echo $c1; ?>;
}

.active-view-btn:hover {
    border: solid 1px <?php echo $c1; ?>;
    color: <?php echo $c1; ?>;
}

.listing-properties-box .detail header.title a {
    color: <?php echo $c1; ?>;
}

.listing-properties-box .detail .title::after {
    background-color: <?php echo $c1; ?>;
}

.show-more-options, .show-more-options:hover {
    color: <?php echo $c1; ?>;
}

.pagination > li > a:hover {
    background: <?php echo $c1; ?>;
    border-color: <?php echo $c1; ?>;
}

.pagination > .active > a {
    background: <?php echo $c1; ?>;
    border-color: <?php echo $c1; ?>;
}

.pagination > .active > a:hover {
    background: <?php echo $c1; ?>;
    border-color: <?php echo $c1; ?>;
}

.blog-box .detail .post-meta span a i {
    color: <?php echo $c1; ?>;
}

.agent-box-list .agent-content h1 a:hover{
    color: <?php echo $c1; ?>;
}
.form-content-box .footer span a {
    color: <?php echo $c1; ?>;
}

blockquote {
    border-left: 5px solid <?php echo $c1; ?>;
}

.banner-search-box{
    border-top: solid 5px <?php echo $c1; ?>;
}

.agent-box-big .agent-content h1 a:hover{
    color: <?php echo $c1; ?>;
}

.tab-style-2-line > .nav-tabs > li.active > a {
    border: solid 1px <?php echo $c1; ?> !important;
    background: <?php echo $c1; ?>;
}

.tab-style-2-line > .nav-tabs > li.active > a:hover {
    border: solid 1px <?php echo $c1; ?> !important;
    background: <?php echo $c1; ?> !important;;
}


.archives ul li a:hover{
    color: <?php echo $c1; ?>;
}
.range-slider .ui-slider .ui-slider-handle {
    background: <?php echo $c1; ?>;
}

.range-slider .ui-slider .ui-slider-handle {
    border: 2px solid <?php echo $c1; ?>;
}

.property-tag.featured {
    background: <?php echo $c1; ?>;
}

.range-slider .ui-widget-header {
    background-color: <?php echo $c1; ?>;
}

.category-posts ul li a:hover {
    color: <?php echo $c1; ?>;
}

.tags-box ul li a:hover {
    border: 1px solid <?php echo $c1; ?>;
    background: <?php echo $c1; ?>;
}

.latest-tweet a {
    color: <?php echo $c1; ?>;
}

.popular-posts .media-heading a {
    color: <?php echo $c1; ?>;
}

.comment-meta-author a {
    color: <?php echo $c1; ?>;
}

.comment-meta-reply a {
    background-color: <?php echo $c1; ?>;
}

.contact-details .media .media-left i {
    background: <?php echo $c1; ?>;
}

.about-text ul li i {
    color: <?php echo $c1; ?>;
}

.breadcrumbs li a:hover {
    color: <?php echo $c1; ?>;
}

.top-header ul li a:hover {
    color: <?php echo $c1; ?>;
}

.helping-center .icon {
    color: <?php echo $c1; ?>;
}

.main-title-2 h1 a:hover{
    color: <?php echo $c1; ?>;
}

.agent-box-big .contact p i{
    color: <?php echo $c1; ?>;
}

.agent-box-list .contact p i{
    color: <?php echo $c1; ?>;
}

.option-bar h4 {
    color: <?php echo $c1; ?>;
}

.attachments a:hover{
    color: <?php echo $c1; ?>;
}

.additional-details-list li a:hover{
    color: <?php echo $c1; ?>;
}

.user-account-box  .content ul li .active {
    color: <?php echo $c1; ?>;
    border-left: solid 5px <?php echo $c1; ?>;
}

.user-account-box  .content ul li a:hover{
    color: <?php echo $c1; ?>;
    border-left: solid 5px <?php echo $c1; ?>;
}

.photoUpload {
    background: #fff;
    color: <?php echo $c1; ?>;
}

.user-account-box .header{
    background: <?php echo $c1; ?>;
}

table.manage-table .title-container .title h4 a{
    color: <?php echo $c1; ?>;
}

table.manage-table .title-container .title span i{
    color: <?php echo $c1; ?>;
    margin-right: 5px;
}

.panel-box span a{
    color: <?php echo $c1; ?>;
}

table.manage-table td.action a:hover{
    color: <?php echo $c1; ?>;
}

.typography-page mark.color {
    background-color: <?php echo $c1; ?>;
}

.list-3 li:before, .list-2 li:before, .list-1 li:before {
    color: <?php echo $c1; ?>;
}

.numbered.color.filled ol > li::before {
    border: 1px solid <?php echo $c1; ?>;
    background-color: <?php echo $c1; ?>;
}

.numbered.color ol > li::before {
    border: 1px solid <?php echo $c1; ?>;
    color: <?php echo $c1; ?>;
}

.map-marker:hover {
    background-color: <?php echo $c1; ?>;
    cursor: pointer;
}
.map-marker:hover:before {
    border-color: <?php echo $c1; ?> transparent transparent transparent;
}

.map-marker.featured:hover {
    background-color: <?php echo $c1; ?>;
}
.map-marker.featured:hover:before {
    border-color: <?php echo $c1; ?> transparent transparent transparent;
}

.map-marker .icon {
    border: 3px solid <?php echo $c1; ?>;
}

.marker-active .map-marker {
    background-color: <?php echo $c1; ?>;
}
.marker-active .map-marker:before {
    border-color: <?php echo $c1; ?> transparent transparent transparent;
}

.map-properties .address i{
    color: <?php echo $c1; ?>;
}

.map-properties-btns .border-button-theme{
    color: <?php echo $c1; ?>; !important;
}

.map-properties-btns .border-button-theme:hover{
    color: #fff !important;
}
.map-properties .map-content h4 a{
    color: <?php echo $c1; ?>;
}

.dropzone-design:hover {
    border: 2px dashed <?php echo $c1; ?>;
}

@media (max-width: 768px) {
    .navbar-default .navbar-toggle{
        background: <?php echo $c1; ?>;
    }

    .navbar-default .navbar-toggle:focus, .navbar-default .navbar-toggle:hover {
        background: <?php echo $c1; ?>;
    }

    .navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:focus, .navbar-default .navbar-nav > .active > a:hover {
        background-color: <?php echo $c1; ?>;
        color: #fff! important;
    }

    .main-header .navbar-default .nav > li > a:hover {
        background: <?php echo $c1; ?>;
    }

    .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus, .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover {
        background-color: <?php echo $c1; ?>; !important;
    }

    .navbar-default .navbar-nav .open .dropdown-menu > li > a {
        background: #eee;
    }
}

.property .button,
input[type=submit] {
  background: <?php echo $c2 ?>;
}

.search-area { background: <?php echo $c1 ?>; }
.buscador-home label { color: white; }
