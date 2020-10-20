$(document).ready(function() {

    $(document).on("keyup", "#current_pwd", function() {
        var current_pwd = $("#current_pwd").val();
        // alert(current_pwd);
        $.ajax({
            type: 'post',
            url: '/admin/check-current-pwd',
            data: { current_pwd: current_pwd },
            success: function(resp) {
                if (resp == false) {
                    $("#chkCurrentPwd").html("<font color=red>รหัสผ่านเดิมผิด</font>");
                } else if (resp == true) {
                    $("#chkCurrentPwd").html("<font color=green>รหัสผ่านเดิมถูก</font>");
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("click", ".updateSectionStatus", function() {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-section-status',
            data: { status: status, section_id: section_id },
            success: function(resp) {
                // alert(resp['status']);
                // alert(resp['section_id']);
                if (resp['status'] == 0) {
                    $("#section-" + section_id).html("<i class='fa fa-toggle-off' aria-hidden='true' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $("#section-" + section_id).html("<i class='fa fa-toggle-on' aria-hidden='true' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("click", ".updateCategoryStatus", function() {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-category-status',
            data: { status: status, category_id: category_id },
            success: function(resp) {
                // alert(resp['status']);
                // alert(resp['category_id']);
                if (resp['status'] == 0) {
                    $("#category-" + category_id).html("<i class='fa fa-toggle-off' aria-hidden='true' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $("#category-" + category_id).html("<i class='fa fa-toggle-on' aria-hidden='true' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("change", "#section_id", function() {
        var section_id = $(this).val();
        $.ajax({
            type: 'post',
            url: '/admin/append-categories-level',
            data: { section_id: section_id },
            success: function(resp) {
                $("#appendCategoriesLevel").html(resp);
            },
            error: function() {
                alert("Error");
            }
        })
    });

    $(document).on("click", ".updateProductStatus", function() {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-product-status',
            data: { status: status, product_id: product_id },
            success: function(resp) {
                // alert(resp['status']);
                // alert(resp['product_id']);
                if (resp['status'] == 0) {
                    $("#product-" + product_id).html("<i class='fa fa-toggle-off' aria-hidden='true' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $("#product-" + product_id).html("<i class='fa fa-toggle-on' aria-hidden='true' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("click", ".updateAttributeStatus", function() {
        var status = $(this).text();
        var attribute_id = $(this).attr("attribute_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-attribute-status',
            data: { status: status, attribute_id: attribute_id },
            success: function(resp) {
                // alert(resp['status']);
                // alert(resp['attribute_id']);
                if (resp['status'] == 0) {
                    $("#attribute-" + attribute_id).html("<i class='fa fa-toggle-off' aria-hidden='true' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $("#attribute-" + attribute_id).html("<i class='fa fa-toggle-on' aria-hidden='true' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("click", ".updateImageStatus", function() {

        var status = $(this).children("i").attr("status");
        var image_id = $(this).attr("image_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-image-status',
            data: { status: status, image_id: image_id },
            success: function(resp) {
                // alert(resp['status']);
                // alert(resp['image_id']);
                if (resp['status'] == 0) {
                    $("#image-" + image_id).html("<i class='fa fa-toggle-off' aria-hidden='true' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $("#image-" + image_id).html("<i class='fa fa-toggle-on' aria-hidden='true' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("click", ".updateBrandStatus", function() {

        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-brand-status',
            data: { status: status, brand_id: brand_id },
            success: function(resp) {
                // alert(resp['status']);
                // alert(resp['brand_id']);
                if (resp['status'] == 0) {
                    $("#brand-" + brand_id).html("<i class='fa fa-toggle-off' aria-hidden='true' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $("#brand-" + brand_id).html("<i class='fa fa-toggle-on' aria-hidden='true' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("click", ".updateBannerStatus", function() {

        var status = $(this).children("i").attr("status");
        var banner_id = $(this).attr("banner_id");
        $.ajax({
            type: 'post',
            url: '/admin/update-banner-status',
            data: { status: status, banner_id: banner_id },
            success: function(resp) {
                // alert(resp['status']);
                // alert(resp['banner_id']);
                if (resp['status'] == 0) {
                    $("#banner-" + banner_id).html("<i class='fa fa-toggle-off' aria-hidden='true' status='Inactive'></i>")
                } else if (resp['status'] == 1) {
                    $("#banner-" + banner_id).html("<i class='fa fa-toggle-on' aria-hidden='true' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    $(document).on("click", ".confirmDelete", function() {
        var record = $(this).attr("record");
        var recordid = $(this).attr("recordid");
        Swal.fire({
            title: 'ลบสินค้า?',
            text: "คุณต้องการลบสินค้าหรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ลบ!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'ลบ!',
                    'คุณลบสินค้าเรียบร้อย.',
                    'success'
                )
                window.location.href = "/admin/delete-" + record + "/" + recordid;
            }
        });
    });

    $(document).on("click", ".confirmLogout", function() {

        Swal.fire({
            title: 'ออกจากระบบ?',
            text: "คุณต้องการออกจากระบบหรือไม่!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'ออกจากระบบ!',
                    'คุณออกจากระบบเรียบร้อย.',
                    'success'
                )
                window.location.href = "/admin/logout";
            }
        });
    });

    var maxField = 10; //เพิ่มได้ไม่เกิน10
    var addButton = $('.add_button'); //กดปุ่ม
    var wrapper = $('.field_wrapper'); //อินพุต
    var fieldHTML = '<div style="margin-top:10px;"><input type="text" name="size[]" style="width:100px" value="" placeholder="ไซส์"/> <input type="text" name="sku[]" style="width:100px" value="" placeholder="โค้ดย่อย"/> <input type="text" name="price[]" style="width:100px" value="" placeholder="ราคา"/> <input type="text" name="stock[]" style="width:100px" value="" placeholder="จำนวน"/><a href="javascript:void(0);" class="remove_button"> ลบ</a></div>'; //เพิ่มอินพุตใน html
    var x = 1; //ตัวนับ

    //เช็คการคลิกเพิ่ม
    $(addButton).on("click", function() {
        //เช็คว่าไม่เกิน10
        if (x < maxField) {
            x++; //เพิ่มตัวนับ
            $(wrapper).append(fieldHTML); //เพิ่มฟิลใน html
        }
    });

    //เช็คการคลิกลบ
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').remove(); //ลบฟิลใน html
        x--; //ลบตัวนับ
    });
});