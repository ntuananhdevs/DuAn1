<div class="container">
    <h3 class="fw-bold mb-4 mt-4">Thanh Toán</h3>

    <div class="row mt-5">
        <div class="col-md-8">
            <div class="header-form d-flex gap-3">
                <div class="shipping border-active" style="width: 50%;">
                    <p>1. Vận chuyển</p>
                </div>

                <div class="pay border-inactive" style="width: 50%;">
                    <p>2. Thanh toán</p>
                </div>
            </div>

            <div id="form1" class="border p-3 mt-5">
                <h4>1. Lựa chọn phương thức vận chuyển</h4>
                <p class="fw-bold">Địa chỉ nhận hàng</p>
                <form action="" class="p-2">
                    <div class="row mb-4">
                        <div class="col">
                            <label for="lastname" class="form-labell">Họ</label>
                            <input type="text" class="custom-input" name="lastname" id="lastname" placeholder="Ho cua ban">
                        </div>
                        <div class="col">
                            <label for="firstname" class="form-labell">Đệm và Tên</label>
                            <input type="text" class="custom-input" name="firstname" id="firstname" placeholder="Ten cua ban">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="email" class="form-labell">Email</label>
                            <input type="text" class="custom-input" name="email" id="email" placeholder="email cua ban">
                        </div>
                        <div class="col">
                            <label for="address" class="form-labell">Địa chỉ</label>
                            <input type="text" class="custom-input" name="address" id="address" placeholder="Địa chỉ chính">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="province" class="form-labell">Tỉnh/Thành phố</label>
                            <select class="custom-select" name="province" id="province">
                                <option value="">Chọn tỉnh/thành phố</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="district" class="form-label">Quận</label>
                            <select class="custom-select" name="district" id="district">
                                <option value="">Chọn quận</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="district" class="form-label">Phường</label>
                            <select class="custom-select" name="district" id="district">
                                <option value="">Chọn phường</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="text" class="custom-input" name="phone" id="phone" placeholder="So dien thoai">
                        </div>
                    </div>
                    <div class="row mt-4 p-2">
                        <h6>Chọn phương thức vận chuyển</h6>
                        <p class="mt-3">Hỗ trợ vận chuyển vào ngày làm việc tiếp theo cho tất cả các đơn đặt hàng. Thời gian vận chuyển có thể thay đổi đối với khu vực ngoại thành.</p>

                        <div class="time-shipping border d-flex justify-content-between align-items-center p-2" style="border-radius: 3px;">
                            <div class="time d-flex align-items-center">
                                <p style="margin: auto 0;">Giao hàng 5 - 6 ngày</p>
                            </div>
                            <div class="price-shipping d-flex align-items-center">
                                <p class="fw-bold" style="margin: auto 0;">Miễn Phí</p>
                            </div>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: center;">
                        <button type="button" id="continueToPayment" class="btn text-white"
                            style="width: 300px; height: 50px; background-color: #00a3e7;">Tiếp Tục
                        </button>
                    </div>
                </form>
            </div>

            <div id="form2" class="mt-5" style="display: none;">
                <div class="address  border p-3">
                    <div class="col d-flex justify-content-between">
                        <h4>1. Lựa chọn phương thức vận chuyển</h4>
                        <p class="fw-550 text-info">Chỉnh sửa</p>
                    </div>
                    <p class="h5">Địa chỉ nhận hàng</p>
                    <div class="shipping m-0 ms-2">
                        <p class="m-0">Tuan Anh</p>
                        <p class="m-0">Số 20, ngõ 285</p>
                        <p>Nghi Trường, Nghi Lộc, Nghệ An, Việt Nam</p>
                        <p>Sdt: 0981714620</p>
                        <p>Email: ntuananh@example.com</p>
                    </div>

                    <hr class="text-muted">
                    <strong>Các phương thức vận chuyển</strong>
                    <p class="mt-2">Giao hàng 5 - 6 ngày</p>
                </div>

            
                <div class="payment  border p-3 mt-4">
                    <h4>2. Phương thức thanh toán</h4>

                    <div class="qr d-flex align-items-center gap-2">
                        <input type="radio" name="payment-method" id="payment-method" style="width: 18px; height: 18px;">
                        <img src="./assets/img/qr.png" alt="" style="width: 80px; height: 60px;">
                        <p class="m-0 fw-550">Thanh toán ngay với thẻ ATM, Internet Banking, QR Code</p>
                    </div>

                    <div class="qr d-flex align-items-center gap-2">
                        <input type="radio" name="payment-method" id="payment-method" style="width: 18px; height: 18px;">
                        <img src="./assets/img/pay_global.png" alt="" style="width: 80px; height: 60px;">
                        <p class="m-0 fw-550">Thanh toán ngay với thẻ quốc tế</p>
                    </div>

                    <div class="qr d-flex align-items-center gap-2">
                        <input type="radio" name="payment-method" id="payment-method" style="width: 18px; height: 18px;">
                        <img src="./assets/img/save.png" alt="" style="width: 80px; height: 60px;">
                        <p class="m-0 fw-550">Trả góp 0% lãi (có phí chuyển đổi)</p>
                    </div>                    
                </div>

                

            </div>
        </div>

        <div class="col-md-4" style="margin-top: 102px;">
            <div class="border p-3">
                <h4>Tóm tắt</h4>
                <div class="row mt-4 ">
                    <div class="col-8">
                        <p>Tổng phụ (Bao gồm VAT)</p>
                    </div>
                    <div class="col-4 ">
                        <p class="text-end">20.000 VND</p>
                    </div>
                    <h6>Miễn phí vận chuyển toàn quốc</h6>
                </div>
                <hr>
                <div class="row">
                    <div class="col">
                        <p><strong class="h3">Tổng</strong> (Bao gồm VAT)</p>
                    </div>
                    <div class="col mt-1 text-end">
                        <h5>20.000.000 VND</h5>
                    </div>
                </div>
                <div class="row d-flex justify-content-between" style="font-size: 14px; ">
                    <div class="col">
                        <p>trong đó VAT (10%)</p>
                    </div>
                    <div class="col text-end">
                        <p>2.000.000 VND</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <input type="checkbox" name="payment-method" id="payment-method">
                        <p style="font-size: 14px; margin: 0 10px;">Tôi đồng ý nhận email sau khi mua hàng để đánh giá sản phẩm và/hoặc khảo sát sản phẩm và dịch vụ.</p>
                    </div>
                </div>
                <button class="btn text-white mt-3" style="width: 100%; height: 50px; background-color: #00a3e7;">Đặt hàng</button>
            </div>
            <div class="products_to_cart border p-3 mt-3">
                <h5>1 Sản phẩm trong giỏ</h5>
                <div class="producst_item_cart d-flex justify-content-center gap-4">
                    <img src="uploads/Products/673a293d4ef22_iphone-16-1.webp" alt="" style="width: 80px; height: 80px;">
                    <div class="name_prd ">
                        <p class="m-0 fw-bold">IPhone 16 Promax (256GB) </p>
                        <div class="quantity d-flex justify-content-between mt-3" style="font-size: 14px;">
                            <p>Số lượng: </p>
                            <p class="text-end">1</p>
                        </div>
                        <div class="price_item d-flex justify-content-between" style="font-size: 14px;">
                            <p>Tổng: </p>
                            <p class="text-end">20.000.000 VND</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script>
    document.getElementById("continueToPayment").addEventListener("click", function() {
        // Hide Form 1 and show Form 2
        document.getElementById("form1").style.display = "none";
        document.getElementById("form2").style.display = "block";

        // Update Header Styles
        document.querySelector(".shipping").classList.remove("border-active");
        document.querySelector(".shipping").classList.add("border-inactive");
        document.querySelector(".pay").classList.remove("border-inactive");
        document.querySelector(".pay").classList.add("border-active");
    });
</script>
<style>
    .header-form div {
        padding-bottom: 10px;
    }

    .border-active {
        border-bottom: 4px solid #00a3e7 !important;
    }

    .border-inactive {
        border-bottom: 4px solid #ccc !important;
    }

    form .row {
        margin-bottom: 15px;
    }

    form input[type="text"],
    form input[type="email"],
    form select {
        height: 40px;
        border-radius: 5px;
        border: 1px solid #ddd;
        padding: 0 10px;
    }

    form input::placeholder {
        color: #ccc;
    }

    form label {
        margin-bottom: 10px;
    }


    /* Reset styling */
    .custom-input,
    .custom-select {
        width: 100%;
        height: 40px;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        outline: none;
        font-size: 14px;
    }

    .custom-input:focus,
    .custom-select:focus {
        border-color: #007bff;
        /* Màu viền khi được chọn */
    }

    .custom-input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    .custom-label {
        font-size: 14px;
        margin-bottom: 5px;
        display: block;
    }
</style>