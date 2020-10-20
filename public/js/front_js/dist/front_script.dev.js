"use strict";

$(document).ready(function () {
  // $.ajaxSetup({
  //     headers: {
  //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //     }
  // });
  $(document).on("change", "#sort", function () {
    var sort = $(this).val();
    var fabric = Get_filter('fabric');
    var sleeve = Get_filter('sleeve');
    var pattern = Get_filter('pattern');
    var fit = Get_filter('fit');
    var occasion = Get_filter('occasion');
    var url = $("#url").val();
    $.ajax({
      url: url,
      method: "post",
      data: {
        fabric: fabric,
        sleeve: sleeve,
        pattern: pattern,
        fit: fit,
        occasion: occasion,
        sort: sort,
        url: url
      },
      success: function success(data) {
        $('.filter_products').html(data);
      }
    });
  });
  $(document).on("click", ".fabric", function () {
    var fabric = Get_filter('fabric');
    var sleeve = Get_filter('sleeve');
    var pattern = Get_filter('pattern');
    var fit = Get_filter('fit');
    var occasion = Get_filter('occasion');
    var sort = $("#sort option:selected").text();
    var url = $("#url").val();
    $.ajax({
      url: url,
      method: "post",
      data: {
        fabric: fabric,
        sleeve: sleeve,
        pattern: pattern,
        fit: fit,
        occasion: occasion,
        sort: sort,
        url: url
      },
      success: function success(data) {
        $('.filter_products').html(data);
      }
    });
  });
  $(document).on("click", ".sleeve", function () {
    var fabric = Get_filter('fabric');
    var sleeve = Get_filter('sleeve');
    var pattern = Get_filter('pattern');
    var fit = Get_filter('fit');
    var occasion = Get_filter('occasion');
    var sort = $("#sort option:selected").text();
    var url = $("#url").val();
    $.ajax({
      url: url,
      method: "post",
      data: {
        fabric: fabric,
        sleeve: sleeve,
        pattern: pattern,
        fit: fit,
        occasion: occasion,
        sort: sort,
        url: url
      },
      success: function success(data) {
        $('.filter_products').html(data);
      }
    });
  });
  $(document).on("click", ".pattern", function () {
    var fabric = Get_filter('fabric');
    var sleeve = Get_filter('sleeve');
    var pattern = Get_filter('pattern');
    var fit = Get_filter('fit');
    var occasion = Get_filter('occasion');
    var sort = $("#sort option:selected").text();
    var url = $("#url").val();
    $.ajax({
      url: url,
      method: "post",
      data: {
        fabric: fabric,
        sleeve: sleeve,
        pattern: pattern,
        fit: fit,
        occasion: occasion,
        sort: sort,
        url: url
      },
      success: function success(data) {
        $('.filter_products').html(data);
      }
    });
  });
  $(document).on("click", ".fit", function () {
    var fabric = Get_filter('fabric');
    var sleeve = Get_filter('sleeve');
    var pattern = Get_filter('pattern');
    var fit = Get_filter('fit');
    var occasion = Get_filter('occasion');
    var sort = $("#sort option:selected").text();
    var url = $("#url").val();
    $.ajax({
      url: url,
      method: "post",
      data: {
        fabric: fabric,
        sleeve: sleeve,
        pattern: pattern,
        fit: fit,
        occasion: occasion,
        sort: sort,
        url: url
      },
      success: function success(data) {
        $('.filter_products').html(data);
      }
    });
  });
  $(document).on("click", ".occasion", function () {
    var fabric = Get_filter('fabric');
    var sleeve = Get_filter('sleeve');
    var pattern = Get_filter('pattern');
    var fit = Get_filter('fit');
    var occasion = Get_filter('occasion');
    var sort = $("#sort option:selected").text();
    var url = $("#url").val();
    $.ajax({
      url: url,
      method: "post",
      data: {
        fabric: fabric,
        sleeve: sleeve,
        pattern: pattern,
        fit: fit,
        occasion: occasion,
        sort: sort,
        url: url
      },
      success: function success(data) {
        $('.filter_products').html(data);
      }
    });
  });

  function Get_filter(class_name) {
    var filter = [];
    $('.' + class_name + ':checked').each(function () {
      filter.push($(this).val());
    });
    return filter;
  }

  $("#getPrice").change(function () {
    var size = $(this).val(); // if (size == "") {
    //     alert("Please select Size");
    //     return false;
    // }

    var product_id = $(this).attr("product-id");
    $.ajax({
      url: '/get-product-price',
      data: {
        size: size,
        product_id: product_id
      },
      type: 'post',
      success: function success(resp) {
        // alert(resp);
        $(".getAttrPrice").html("ราคา " + resp + " บาท");
      },
      error: function error() {
        alert("Error");
      }
    });
  });
});