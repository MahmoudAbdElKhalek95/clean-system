
<div class="col-md-12 text-center">
    @if ($item)
    <div class="alert alert-success" id="successMessage" style="display: none"></div>
    <div class="card-datatable table-responsive">
        <table class="dt-multilingual table datatables-ajax">
            <thead>
                <tr>
                    <th>الاسم</th>
                    <th>رقم الهاتف</th>
                    <th>كم التبرعات</th>
                    <th>التصنيف</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->amounts }}</td>
                    <td>{{ $item->donerType->name??'' }}</td>
                </tr>
            </tbody>

        </table>
        <input type="hidden" id="doner_id" value="{{ $item->id }}">
        <input type="hidden" id="doner_id" value="{{ $item->phone }}">
        <textarea name="" class="form-control" id="notes" placeholder="ملاحظات" cols="30" rows="3"></textarea>
        <br>
        <button class="btn btn-primary" type="button" id="contactUs" onclick="sendRequestNotes()">ارسال</button>
        <br>
        <br>
    </div>
    @else
    <h3 class="text-danger">عفوا رقم الهاتف غير فى قائمة المتبرعين</h3>
    @endif

    @if ($data)
    <div class="alert alert-success" id="successMessage" style="display: none"></div>
    <div class="card-datatable table-responsive">
        <table class="dt-multilingual table datatables-ajax">
            <thead>
                <tr>
                    <th>المبلغ </th>
                    <th>القسم </th>
                    <th>المشروع </th>
                    <th>الوقت والتاريخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)

                <tr>
                    <td>{{ $item->total }}</td>
                    <td>{{ $item->project_dep_name }}</td>
                    <td>{{ $item->project_name }}</td>
                    <td>{{ $item->created_at }}</td>
                </tr>
                @endforeach
            </tbody>

        </table>

    </div>
    @else
    <h3 class="text-danger">لا توجد اى عمليات تبرع</h3>
    @endif
</div>
