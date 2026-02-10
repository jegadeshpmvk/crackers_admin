<div class="import_popup">
    <div class="import_popup_container">
        <div class="import_popup_header">
            <span></span>
            <a class="fa fa-close"></a>
        </div>
        <div class="import_popup_content">
            <div class="upload-box" id="drop-area">
                <form method="post" class="import_form" enctype="multipart/form-data" action="<?= Yii::$app->urlManager->createUrl('/admin/category/import-excel') ?>">
                    <input type="file" id="fileInput" name="excel_file" accept=".xlsx" hidden>

                    <div class="upload-content">
                        <div class="icon">📂</div>
                        <p><strong>Drag & Drop files here</strong></p>
                        <span>or</span>
                        <button type="button" id="browseBtn">Browse File</button>
                    </div>
            </div>
        </div>
        <div class="import_popup_footer">
            <span id="fileName"></span>
            <button type="submit" class="import_submit">Submit</button>
        </div>
    </div>
</div>