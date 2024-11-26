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
                <form method="POST" action="">
                    <div class="row mb-4">
                        <div class="col">
                            <label for="lastname" class="form-labell">Họ</label>
                            <input type="text" class="custom-input" name="lastname" id="lastname" placeholder="Ho cua ban" value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>">
                        </div>
                        <div class="col">
                            <label for="firstname" class="form-labell">Đệm và Tên</label>
                            <input type="text" class="custom-input" name="firstname" id="firstname" placeholder="Ten cua ban" value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="email" class="form-labell">Email</label>
                            <input type="text" class="custom-input" name="email" id="email" placeholder="email cua ban" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                        </div>
                        <div class="col">
                            <label for="phone" class="form-labell">Số diện thoại</label>
                            <input type="text" class="custom-input" name="phone" id="phone" placeholder="Số điện thoại" value="<?php echo htmlspecialchars($_POST['phone'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="province" class="form-label">Chọn Tỉnh:</label>
                            <select id="province" name="province" class="custom-select" onchange="this.form.submit()">
                                <option value="">Chọn Tỉnh</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?php echo $province['code']; ?>"
                                        <?php echo isset($selectedProvince) && $selectedProvince === $province['code'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($province['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="district" class="form-label">Chọn Huyện:</label>
                            <select id="district" name="district" class="custom-select" onchange="this.form.submit()">
                                <option value="">Chọn Huyện</option>
                                <?php if (isset($districts)): ?>
                                    <?php foreach ($districts as $district): ?>
                                        <option value="<?php echo $district['code']; ?>"
                                            <?php echo isset($selectedDistrict) && $selectedDistrict === $district['code'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($district['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <label for="ward" class="form-label">Phường</label>
                            <select class="custom-select" name="ward" id="ward">
                                <option value="">Chọn phường</option>
                                <?php if (isset($wards)): ?>
                                    <?php foreach ($wards as $ward): ?>
                                        <option value="<?php echo $ward['code']; ?>">
                                            <?php echo htmlspecialchars($ward['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="custom-input" name="address" id="address" placeholder="Địa chỉ chính" value="<?php echo htmlspecialchars($_POST['address'] ?? ''); ?>">
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
                            style="width: 300px; height: 50px;">Tiếp Tục
                        </button>
                    </div>
                </form>
            </div>
            <div id="form2" class="mt-5" style="display: none;">
                <div class="address  border p-3">
                    <div class="col d-flex justify-content-between">
                        <h4>1. Lựa chọn phương thức vận chuyển</h4>
                        <p class="fw-550 text-info edit" style="cursor: pointer;">Chỉnh sửa</p>
                    </div>
                    <p class="h5">Địa chỉ nhận hàng</p>
                    <div class="shipping m-0 ms-2">
                        <p class="m-0"></p>
                        <p class="m-0"></p>
                        <p></p>
                        <p></p>
                        <p></p>
                    </div>

                    <hr class="text-muted">
                    <strong>Các phương thức vận chuyển</strong>
                    <p class="mt-2">Giao hàng 5 - 6 ngày</p>
                </div>
                <form action="?act=order" method="POST" id="paymentForm">
                    <div class="payment border p-3 mt-4">
                        <h4>2. Phương thức thanh toán</h4>

                        <div class="qr d-flex align-items-center gap-2" style="cursor: pointer;" onclick="document.getElementById('payment-method-qr').checked = true; validateForm();">
                            <input type="radio" name="payment-method" id="payment-method-qr" style="width: 18px; height: 18px;" value="ATM">
                            <img src="./assets/img/qr.png" alt="" style="width: 80px; height: 60px;">
                            <p class="m-0 fw-550">Thanh toán ngay với thẻ ATM, Internet Banking, QR Code</p>
                        </div>

                        <div class="qr d-flex align-items-center gap-2" style="cursor: pointer;" onclick="document.getElementById('payment-method-global').checked = true; validateForm();">
                            <input type="radio" name="payment-method" id="payment-method-global" style="width: 18px; height: 18px;" value="Global">
                            <img src="./assets/img/pay_global.png" alt="" style="width: 80px; height: 60px;">
                            <p class="m-0 fw-550">Thanh toán ngay với thẻ quốc tế</p>
                        </div>

                        <div class="qr d-flex align-items-center gap-2" style="cursor: pointer;" onclick="document.getElementById('payment-method-installment').checked = true; validateForm();">
                            <input type="radio" name="payment-method" id="payment-method-installment" style="width: 18px; height: 18px;" value="Installment">
                            <img src="./assets/img/save.png" alt="" style="width: 80px; height: 60px;">
                            <p class="m-0 fw-550">Trả góp 0% lãi (có phí chuyển đổi)</p>
                        </div>

                        <div class="qr d-flex align-items-center gap-3 mt-2" style="cursor: pointer;" onclick="document.getElementById('payment-method-cod').checked = true; validateForm();">
                            <input type="radio" name="payment-method" id="payment-method-cod" style="width: 18px; height: 18px;" value="COD">
                            <img src="./assets/img/shipp.png" alt="" style="width: 40px; height: 30px; margin-right: 25px;">
                            <p class="m-0 fw-550">Thanh toán khi nhận hàng</p>
                        </div>
                    </div>


                    <input type="hidden" name="fullname" id="hidden-fullname">
                    <input type="hidden" name="email" id="hidden-email">
                    <input type="hidden" name="address" id="hidden-address">
                    <input type="hidden" name="phone" id="hidden-phone">

            </div>
        </div>
        <?php
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $sessionId = null;
        } else {
            $userId = null;
            $sessionId = session_id();
        }
        $cart = new ProductsContronller(new products());
        $cart_item = $cart->getCartItems($userId, $sessionId);
        ?>
        <div class="col-md-4" style="margin-top: 102px;">
            <div class="border p-3">
                <h4>Tóm tắt</h4>
                <div class="row mt-4 d-flex justify-content-between">
                    <div class="col-8">
                        <p>Tổng phụ (Bao gồm VAT)</p>
                    </div>
                    <div class="col-4 ">
                        <?php
                        $total = 0;
                        foreach ($cart_item as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                        $vat = $total * 0.1;
                        $subtotal = $total + $vat;
                        ?>
                        <p class="text-end me-2" style="white-space: nowrap;"><?= number_format($subtotal, 0, ',', '.') ?> VND</p>
                    </div>
                    <h6 style="text-align: left;">Miễn phí vận chuyển toàn quốc</h6>

                    <hr>
                    <div class="row">
                        <div class="col d-flex ">
                            <p style="white-space: nowrap;"><strong class="h3">Tổng</strong> (Bao gồm VAT)</p>
                            <div class="col mt-1 text-end ms-3">
                                <input type="hidden" name="total" value="<?= $subtotal ?>">
                                <p class="text-end h5" style="white-space: nowrap; "><?= number_format($subtotal, 0, ',', '.') ?> VND</p>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between" style="font-size: 14px; ">
                            <div class="col">
                                <p>trong đó VAT (10%)</p>
                            </div>
                            <div class="col text-end">
                                <p><?= number_format($vat, 0, ',', '.') ?> VND</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <div class="col d-flex align-items-center">
                                    <input type="checkbox" name="agreement" id="payment-method-checkbox" onclick="validateForm();">
                                    <p style="font-size: 14px; margin: 0 10px;">Tôi đồng ý nhận email sau khi mua hàng để đánh giá sản phẩm và/hoặc khảo sát sản phẩm và dịch vụ.</p>
                                </div>
                            </div>
                        </div>
                        <button id="orderButton" class="btn text-white mt-3" style="width: 100%; height: 50px; background-color: #cccccc;" disabled>Đặt hàng</button>
                        </div>
                </div>
            </div>

            <div class="products_to_cart border p-3 mt-3">
                <h5><?php echo $cart_item[0]['total_quantity']; ?> Sản phẩm trong giỏ</h5>
                <?php $i = 0;
                foreach ($cart_item as $item): $i++; ?>
                    <?php if ($i > 1): ?>
                        <hr>
                    <?php endif; ?>
                    <div class="producst_item_cart d-flex" style="gap: 10px;">
                        <img src="<?php echo removeLeadingDots($item['img']) ?>" alt="" style="width: 80px; height: 80px;">
                        <div class="name_prd d-flex flex-column justify-content-between">
                            <p class="m-0 fw-bold"><?php echo $item['product_name']; ?> (<?php echo $item['storage']; ?>)</p>
                            <p class="m-0">Số lượng:
                                <span class="text-end" style="margin-left: 200px"><?php echo $item['quantity']; ?></span>
                            </p>
                            <p class="m-0 d-flex justify-content-between">
                                <span>Tổng:</span>
                                <span><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?> đ</span>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById("continueToPayment").addEventListener("click", function() {
            // Lấy thông tin từ các trường trong form1
            const lastname = document.getElementById("lastname").value;
            const firstname = document.getElementById("firstname").value;
            const email = document.getElementById("email").value;
            const address = document.getElementById("address").value;
            const province = document.getElementById("province").options[document.getElementById("province").selectedIndex].text;
            const district = document.getElementById("district").options[document.getElementById("district").selectedIndex].text;
            const ward = document.getElementById("ward").options[document.getElementById("ward").selectedIndex].text;
            const phone = document.getElementById("phone").value;

            // Tạo nội dung hiển thị
            const addressContent = `
        <p class="m-0">${firstname} ${lastname}</p>
        <p class="m-0">${address}</p>
        <p>${ward}, ${district}, ${province}, Việt Nam</p>
        <p>Sdt: ${phone}</p>
        <p>Email: ${email}</p>
    `;

            // Hiển thị thông tin vào class address
            document.querySelector(".address .shipping").innerHTML = addressContent;

            // Gán dữ liệu vào các trường ẩn

            fullName = `${lastname} ${firstname}`;
            document.getElementById("hidden-fullname").value = fullName;
            document.getElementById("hidden-email").value = email;
            document.getElementById("hidden-address").value = `${address}, ${ward}, ${district}, ${province}, Việt Nam`;
            document.getElementById("hidden-phone").value = phone;

            // Chuyển đổi hiển thị giữa form1 và form2
            document.getElementById("form1").style.display = "none";
            document.getElementById("form2").style.display = "block";

            // Cập nhật trạng thái của header
            document.querySelector(".shipping").classList.remove("border-active");
            document.querySelector(".shipping").classList.add("border-inactive");
            document.querySelector(".pay").classList.remove("border-inactive");
            document.querySelector(".pay").classList.add("border-active");
        });
        document.querySelector(".address .edit").addEventListener("click", function() {
            // Hiển thị lại form1 và ẩn form2
            document.getElementById("form1").style.display = "block";
            document.getElementById("form2").style.display = "none";

            // Cập nhật trạng thái của header
            document.querySelector(".pay").classList.remove("border-active");
            document.querySelector(".pay").classList.add("border-inactive");
            document.querySelector(".shipping").classList.remove("border-inactive");
            document.querySelector(".shipping").classList.add("border-active");
        });



        //validate form
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('form1');
            const inputs = form.querySelectorAll('.custom-input, .custom-select');
            const continueButton = document.getElementById('continueToPayment');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');

            // Khởi đầu: nút bị vô hiệu hóa
            continueButton.classList.add('disabled');

            // Hàm kiểm tra định dạng email
            function isValidEmail(email) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Hàm kiểm tra định dạng số điện thoại
            function isValidPhone(phone) {
                const phoneRegex = /^[0-9]{10}$/;
                return phoneRegex.test(phone);
            }

            // Hàm kiểm tra một input
            function validateInput(input) {
                let isValid = true;
                const value = input.value.trim();

                // Kiểm tra rỗng
                if (value === '') {
                    showError(input, 'Trường này không được để trống');
                    isValid = false;
                } else {
                    // Kiểm tra email hoặc số điện thoại
                    if (input === emailInput && !isValidEmail(value)) {
                        showError(input, 'Email không hợp lệ');
                        isValid = false;
                    } else if (input === phoneInput && !isValidPhone(value)) {
                        showError(input, 'Số điện thoại không hợp lệ');
                        isValid = false;
                    } else {
                        hideError(input); // Xóa lỗi nếu hợp lệ
                    }
                }

                if (!isValid) {
                    input.classList.add('error');
                } else {
                    input.classList.remove('error');
                }
                return isValid;
            }

            // Hàm kiểm tra toàn bộ form để bật/tắt nút Tiếp Tục
            function validateForm() {
                let isFormValid = true;
                inputs.forEach(input => {
                    if (input.value.trim() === '' || input.classList.contains('error')) {
                        isFormValid = false;
                    }
                });

                // Kích hoạt hoặc vô hiệu hóa nút
                if (isFormValid) {
                    continueButton.classList.remove('disabled');
                    continueButton.classList.add('enabled');
                } else {
                    continueButton.classList.remove('enabled');
                    continueButton.classList.add('disabled');
                }
            }

            // Hiển thị thông báo lỗi
            function showError(input, message) {
                let errorElement = input.nextElementSibling;
                if (!errorElement || !errorElement.classList.contains('error-message')) {
                    errorElement = document.createElement('div');
                    errorElement.classList.add('error-message');
                    errorElement.style.color = 'red';
                    errorElement.style.fontSize = '12px';
                    input.parentNode.appendChild(errorElement);
                }
                errorElement.textContent = message;
            }

            // Ẩn thông báo lỗi
            function hideError(input) {
                const errorElement = input.nextElementSibling;
                if (errorElement && errorElement.classList.contains('error-message')) {
                    errorElement.remove();
                }
            }

            // Sự kiện khi bấm vào nút Tiếp Tục
            continueButton.addEventListener('click', function(e) {
                if (!validateForm()) {
                    e.preventDefault(); // Ngăn không cho tiếp tục nếu không hợp lệ
                }
            });

            // Sự kiện kiểm tra từng input khi thay đổi
            inputs.forEach(input => {
                input.addEventListener('input', function() {
                    validateInput(input); // Chỉ kiểm tra input này
                    validateForm(); // Cập nhật trạng thái nút
                });
            });
        });
        function validateForm() {
        // Check if a payment method is selected
        const paymentSelected = document.querySelector('input[name="payment-method"]:checked') !== null;
        // Check if the agreement checkbox is checked
        const checkboxChecked = document.getElementById('payment-method-checkbox').checked;

        // Enable the button if both conditions are met
        const orderButton = document.getElementById('orderButton');
        if (paymentSelected && checkboxChecked) {
            orderButton.disabled = false;
            orderButton.style.backgroundColor = '#007bff'; // Change button color to active state
        } else {
            orderButton.disabled = true;
            orderButton.style.backgroundColor = '#cccccc'; // Keep button disabled color
        }
    }
    </script>
    <style>
        /* CSS cho input khi có lỗi */
        .custom-input.error,
        .custom-select.error {
            border-color: red;
        }

        /* CSS cho nút bấm khi bị vô hiệu hóa */
        .btn.disabled {
            background-color: grey;
            cursor: not-allowed;
            pointer-events: none;
            /* Ngăn chặn sự kiện bấm */
        }

        /* CSS cho nút bấm khi hợp lệ */
        .btn.enabled {
            background-color: #00a3e7;
            cursor: pointer;
            pointer-events: auto;
            /* Cho phép sự kiện bấm */
        }

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

        input::placeholder {
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