<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>تسجيل دخول</title>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{ asset('site') }}/assets/c">
    <link rel="stylesheet" href="{{ asset('assets/admin/css-rtl/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('site') }}/assets/css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
  </head>
<body>

    <div>

        <!-- header -->
        <div class="row main-nav">

        </div>

        <div class="container">

            <div class="row" style="margin-top: 64px; margin-bottom: 64px;">
                <div class="col-3"></div>
                <div class="col-12 col-lg-6">
                    <div class="card form-card p-5">
                        <div class="card-body">
                          <h1 class="card-title fw-bold text-center mb-4" style="color: #508ABB;">تسجيل دخول</h1>

                          <div class="mt-5">
                            <form action="{{ route('admin.postLogin') }}" method="POST">
                                @csrf
                                <div class="mb-3 ">
                                    <label for="phone" class="form-label fw-bold">رقم الجوال</label>
                                    <div class="position-relative">
                                        <input type="number" style="@error('phone') border: 1px solid red @enderror" class="form-control custom-field" id="phone" name="phone" placeholder="ادخل رقم الجوال">
                                        <div class="position-absolute form-icon" >
                                            <img src="{{ asset('site') }}/assets/img/phone.svg" width="20" height="20" alt="">
                                        </div>
                                    </div>
                                    @error('phone')
                                       <span class="text-danger error">{{ $message }}</span>
                                   @enderror
                                @include('flash::message')
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" style="width: 100%; height: 56px; border-radius: 65px;" class="btn mb-3 fw-bold bg-primary" type="button">تسجيل دخول</button>
                                </div>
                                {{-- <p class="text-center fw-bold">تسجيل دخول عن طريق</p>
                                <div class="d-grid gap-2">
                                    <button style="background-color: #E54338; color: #fff; width: 100%; height: 56px; border-radius: 65px;" class="btn mb-3 fw-bold" type="button">
                                        <img class="ms-1" src="{{ asset('site') }}/assets/img/google.svg" width="16" height="16" alt="">
                                        جوجل
                                    </button>
                                </div>
                                <div class="d-grid gap-2">
                                    <button  style="background-color: #2F4F8A; color: #fff; width: 100%; height: 56px; border-radius: 65px;" class="btn mb-3 fw-bold" type="button">
                                        <img class="ms-1" src="{{ asset('site') }}/assets/img/facebook.svg" width="16" height="16" alt="">
                                        فيسبوك
                                    </button>
                                </div> --}}
                            </form>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/admin/vendors/js/bootstrap/bootstrap.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script> --}}
</body>
</html>
