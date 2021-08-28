<div id="form">
  <div id="left-form">
    <div class="form-group">
      <label for="title">
        <legend>Tiêu đề:</legend>
      </label>
      <input type="text" class="form-control" id="title">
    </div>
    <div class="form-group">
      <label for="title">
        <legend>Thể loại:</legend>
      </label><br>
      <select name="type" id="type">
        <option value="study">Học tập</option>
        <option value="fee">Học phí</option>
        <option value="extracurricular">Ngoại khóa</option>
        <option value="social_payment">Chi trả xã hội</option>
        <option value="others">Thông báo khác</option>
      </select>
    </div>
    <div class="form-group mt-4">
      <label for="content">
        <legend>Nội dung:</legend>
      </label><br>
      <span id="notice">*Nếu nội dung thông báo có đường dẫn tệp,
                hãy thao tác trực tiếp ở phần dưới trong trường hợp muốn thêm hoặc xóa
                thay vì sửa trực tiếp ở phần nội dung.
            </span>
      <textarea cols="30" rows="10" class="form-control" id="content"></textarea>
    </div>
    <div class="form-group mt-4">
      <label for="attach-link">
        <legend>Đính kèm link: (Enter để xác nhận)</legend>
      </label><br>
      <input type="text" class="form-control" id="attach-link">
    </div>
    <div id="link-area" class="form-group mt-4">
    </div>
  </div>
  <div id="right-form" class="form-group mt-4">
    <div class="template">
      <label for="title">
        <legend>Một số mẫu thông báo:</legend>
      </label><br>
      <select class="template" id="template">
        <option value="empty"></option>
        <option value="study">Học tập</option>
        <option value="fee">Học phí</option>
        <option value="extracurricular">Ngoại khóa</option>
        <option value="social_payment">Chi trả xã hội</option>
        <option value="others">Thông báo khác</option>
      </select>
    </div>

    <div class="form-group mt-4">
      <label for="time-start" class="select_date">Ngày bắt đầu:</label>
      <input type="date" class="input-date" id="time-start" data-date="" data-date-format="DD/MM/YYYY">
      <button class="btn btn-primary time-start disable" name="reset_button">Bỏ chọn</button>
    </div>
    <div class="form-group mt-4">
      <label for="time-end" class="select_date">Ngày kết thúc:</label>
      <input type="date" class="input-date" id="time-end" data-date="" data-date-format="DD/MM/YYYY">
      <button class="btn btn-primary time-end disable" name="reset_button">Bỏ chọn</button>
    </div>
  </div>
</div>
