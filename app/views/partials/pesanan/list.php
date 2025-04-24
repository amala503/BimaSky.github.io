<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;

//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pesanan/add");
$can_edit = ACL::is_allowed("pesanan/edit");
$can_view = ACL::is_allowed("pesanan/view");
$can_delete = ACL::is_allowed("pesanan/delete");
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list" data-display-type="table"
    data-page-url="<?php print_link($current_page); ?>">
    <?php
    if ($show_header == true) {
        ?>
        <div class="bg-light p-3 mb-3">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col ">
                        <h4 class="record-title">Pesanan</h4>
                    </div>
                    <div class="col-sm-3 ">
                        <a class="btn btn btn-primary my-1" href="<?php print_link("pesanan/add") ?>">
                            <i class="fa fa-plus"></i>
                            Add New Pesanan
                        </a>
                    </div>
                    <div class="col-sm-4 ">
                        <form class="search" action="<?php print_link('pesanan'); ?>" method="get">
                            <div class="input-group">
                                <input value="<?php echo get_value('search'); ?>" class="form-control" type="text"
                                    name="search" placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 comp-grid">

                        <!-- Notifikasi -->
                        <?php if (!empty($this->view->notifikasi)): ?>
                            <?php echo $this->view->notifikasi; ?>
                        <?php endif; ?>

                        <div class="">
                            <!-- Page bread crumbs components-->
                            <?php
                            if (!empty($field_name) || !empty($_GET['search'])) {
                                ?>
                                <hr class="sm d-block d-sm-none" />
                                <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                                    <ul class="breadcrumb m-0 p-1">
                                        <?php
                                        if (!empty($field_name)) {
                                            ?>
                                            <li class="breadcrumb-item">
                                                <a class="text-decoration-none" href="<?php print_link('pesanan'); ?>">
                                                    <i class="fa fa-angle-left"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item">
                                                <?php echo (get_value("tag") ? get_value("tag") : make_readable($field_name)); ?>
                                            </li>
                                            <li class="breadcrumb-item active text-capitalize font-weight-bold">
                                                <?php echo (get_value("label") ? get_value("label") : make_readable(urldecode($field_value))); ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                        if (get_value("search")) {
                                            ?>
                                            <li class="breadcrumb-item">
                                                <a class="text-decoration-none" href="<?php print_link('pesanan'); ?>">
                                                    <i class="fa fa-angle-left"></i>
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item text-capitalize">
                                                Search
                                            </li>
                                            <li class="breadcrumb-item active text-capitalize font-weight-bold">
                                                <?php echo get_value("search"); ?>
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </nav>
                                <!--End of Page bread crumbs components-->
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
    <div class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class=" animated fadeIn page-content">
                        <div id="pesanan-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-striped table-sm text-left">
                                    <thead class="table-header bg-light">
                                        <tr>
                                            <th class="td-checkbox">
                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                    <input class="toggle-check-all custom-control-input"
                                                        type="checkbox" />
                                                    <span class="custom-control-label"></span>
                                                </label>
                                            </th>
                                            <th class="td-sno">#</th>
                                            <th class="td-id"> Id</th>
                                            <th class="td-pelanggan_id"> Pelanggan Id</th>
                                            <th class="td-tanggal_pesanan"> Tanggal Pesanan</th>
                                            <th class="td-status"> Status</th>
                                            <th class="td-total_harga_produk"> Total Harga Produk</th>
                                            <th class="td-pajak"> Pajak</th>
                                            <th class="td-biaya_pengiriman"> Biaya Pengiriman</th>
                                            <th class="td-total_harga_akhir"> Total Harga Akhir</th>
                                            <th class="td-metode_pembayaran"> Metode Pembayaran</th>
                                            <th class="td-metode_pengiriman"> Metode Pengiriman</th>
                                            <th class="td-kode_promo"> Kode Promo</th>
                                            <th class="td-bukti_transfer"> Bukti Transfer</th>
                                            <th class="td-kode_pesanan"> Kode Pesanan</th>
                                            <th class="td-btn"></th>
                                        </tr>
                                    </thead>
                                    <?php
                                    if (!empty($records)) {
                                        ?>
                                        <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                            <!--record-->
                                            <?php
                                            $counter = 0;
                                            foreach ($records as $data) {
                                                $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                                $counter++;
                                                ?>
                                                <tr>
                                                    <th class=" td-checkbox">
                                                        <label class="custom-control custom-checkbox custom-control-inline">
                                                            <input class="optioncheck custom-control-input" name="optioncheck[]"
                                                                value="<?php echo $data['id'] ?>" type="checkbox" />
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                    </th>
                                                    <th class="td-sno"><?php echo $counter; ?></th>
                                                    <td class="td-id"><a
                                                            href="<?php print_link("pesanan/view/$data[id]") ?>"><?php echo $data['id']; ?></a>
                                                    </td>
                                                    <td class="td-pelanggan_id">
                                                        <span data-value="<?php echo $data['pelanggan_id']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="pelanggan_id" data-title="Enter Pelanggan Id"
                                                            data-placement="left" data-toggle="click" data-type="number"
                                                            data-mode="popover" data-showbuttons="left" class="is-editable">
                                                            <?php echo $data['pelanggan_id']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-tanggal_pesanan"> <?php echo $data['tanggal_pesanan']; ?></td>
                                                    <td class="td-status">
                                                        <div class="dropdown">
                                                            <button
                                                                class="btn btn-sm <?php echo getStatusBadgeClass($data['status']); ?> dropdown-toggle"
                                                                type="button" id="statusDropdown<?php echo $data['id']; ?>"
                                                                data-toggle="dropdown" aria-haspopup="true"
                                                                aria-expanded="false">
                                                                <?php echo $data['status']; ?>
                                                            </button>
                                                            <div class="dropdown-menu"
                                                                aria-labelledby="statusDropdown<?php echo $data['id']; ?>">
                                                                <a class="dropdown-item status-change" href="#"
                                                                    data-id="<?php echo $data['id']; ?>" data-status="Diproses"
                                                                    data-url="<?php print_link("pesanan/updatestatus"); ?>">
                                                                    Diproses
                                                                </a>
                                                                <a class="dropdown-item status-change" href="#"
                                                                    data-id="<?php echo $data['id']; ?>" data-status="Dikirim"
                                                                    data-url="<?php print_link("pesanan/updatestatus"); ?>">
                                                                    Dikirim
                                                                </a>
                                                                <a class="dropdown-item status-change" href="#"
                                                                    data-id="<?php echo $data['id']; ?>"
                                                                    data-status="Aktifkan Layanan"
                                                                    data-url="<?php print_link("pesanan/updatestatus"); ?>">
                                                                    Aktifkan Layanan
                                                                </a>
                                                                <a class="dropdown-item status-change" href="#"
                                                                    data-id="<?php echo $data['id']; ?>" data-status="Selesai"
                                                                    data-url="<?php print_link("pesanan/updatestatus"); ?>">
                                                                    Selesai
                                                                </a>
                                                            </div>
                                                        </div>

                                                        <!-- Tombol Download di dalam Loop -->
                                                        <div id="download-button-<?php echo $data['id']; ?>" class="mt-1">
                                                            <?php if ($data['status'] != 'Pending'): ?>
                                                                <a href="javascript:void(0)"
                                                                    onclick="downloadPesanan(<?php echo htmlspecialchars($data['pelanggan_id']); ?>)"
                                                                    class="btn btn-sm btn-outline-primary download-btn">
                                                                    <i class="fa fa-download"></i> Download
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>

                                                        <!-- JavaScript -->
                                                        <script>
                                                            function downloadPesanan(pelanggan_id) {
                                                                // Debug: Pastikan pelanggan_id dikirim
                                                                console.log("ID Pelanggan:", pelanggan_id);

                                                                // Redirect ke URL download dengan pelanggan_id
                                                                window.location.href = "<?php echo print_link('pesanan/download/'); ?>" + pelanggan_id;
                                                            }
                                                        </script>



                                                    <td class="td-total_harga_produk">
                                                        <span data-step="0.1"
                                                            data-value="<?php echo $data['total_harga_produk']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="total_harga_produk" data-title="Enter Total Harga Produk"
                                                            data-placement="left" data-toggle="click" data-type="number"
                                                            data-mode="popover" data-showbuttons="left" class="is-editable">
                                                            <?php echo $data['total_harga_produk']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-pajak">
                                                        <span data-step="0.1" data-value="<?php echo $data['pajak']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="pajak" data-title="Enter Pajak" data-placement="left"
                                                            data-toggle="click" data-type="number" data-mode="popover"
                                                            data-showbuttons="left" class="is-editable">
                                                            <?php echo $data['pajak']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-biaya_pengiriman">
                                                        <span data-step="0.1"
                                                            data-value="<?php echo $data['biaya_pengiriman']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="biaya_pengiriman" data-title="Enter Biaya Pengiriman"
                                                            data-placement="left" data-toggle="click" data-type="number"
                                                            data-mode="popover" data-showbuttons="left" class="is-editable">
                                                            <?php echo $data['biaya_pengiriman']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-total_harga_akhir">
                                                        <span data-step="0.1"
                                                            data-value="<?php echo $data['total_harga_akhir']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="total_harga_akhir" data-title="Enter Total Harga Akhir"
                                                            data-placement="left" data-toggle="click" data-type="number"
                                                            data-mode="popover" data-showbuttons="left" class="is-editable">
                                                            <?php echo $data['total_harga_akhir']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-metode_pembayaran">
                                                        <span data-value="<?php echo $data['metode_pembayaran']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="metode_pembayaran" data-title="Enter Metode Pembayaran"
                                                            data-placement="left" data-toggle="click" data-type="text"
                                                            data-mode="popover" data-showbuttons="left" class="is-editable">
                                                            <?php echo $data['metode_pembayaran']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-metode_pengiriman">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['metode_pengiriman']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="metode_pengiriman" 
                                                            data-title="Enter Metode Pengiriman" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['metode_pengiriman']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-kode_promo">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['kode_promo']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="kode_promo" data-title="Enter Kode Promo"
                                                            data-placement="left" data-toggle="click" data-type="text"
                                                            data-mode="popover" data-showbuttons="left" class="is-editable" <?php } ?>>
                                                            <?php echo $data['kode_promo']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-bukti_transfer">
                                                        <?php if(!empty($data['bukti_transfer'])){ 
                                                            $filename = basename($data['bukti_transfer']);
                                                            $direct_url = SITE_ADDR . 'uploads/buktitransfer/' . $filename;
                                                        ?>
                                                            <div>
                                                                <!-- Hanya tampilkan tombol lihat gambar -->
                                                                <a href="<?php echo $direct_url; ?>" target="_blank" class="btn btn-sm btn-outline-info">
                                                                    <i class="fa fa-image"></i> Lihat Gambar
                                                                </a>
                                                            </div>
                                                        <?php } else { ?>
                                                            <span class="text-muted">Tidak ada bukti</span>
                                                        <?php } ?>
                                                    </td>
                                                    <td class="td-kode_pesanan">
                                                        <span data-value="<?php echo $data['kode_pesanan']; ?>"
                                                            data-pk="<?php echo $data['id'] ?>"
                                                            data-url="<?php print_link("pesanan/editfield/" . urlencode($data['id'])); ?>"
                                                            data-name="kode_pesanan" data-title="Enter Kode Pesanan"
                                                            data-placement="left" data-toggle="click" data-type="text"
                                                            data-mode="popover" data-showbuttons="left" class="is-editable">
                                                            <?php echo $data['kode_pesanan']; ?>
                                                        </span>
                                                    </td>
                                                    <th class="td-btn">
                                                        <a class="btn btn-sm btn-success has-tooltip" title="View Record"
                                                            href="<?php print_link("pesanan/view/$rec_id"); ?>">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record"
                                                            href="<?php print_link("pesanan/edit/$rec_id"); ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <a class="btn btn-sm btn-danger has-tooltip record-delete-btn"
                                                            title="Delete this record"
                                                            href="<?php print_link("pesanan/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>"
                                                            data-prompt-msg="Are you sure you want to delete this record?"
                                                            data-display-style="modal">
                                                            <i class="fa fa-times"></i>
                                                            Delete
                                                        </a>
                                                    </th>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <!--endrecord-->
                                        </tbody>
                                        <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                        <?php
                                    }
                                    ?>
                                </table>
                                <?php
                                if (empty($records)) {
                                    ?>
                                    <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                        <i class="fa fa-ban"></i> No record found
                                    </h4>
                                    <?php
                                }
                                ?>
                            </div>
                            <?php
                            if ($show_footer && !empty($records)) {
                                ?>
                                <div class=" border-top mt-2">
                                    <div class="row justify-content-center">
                                        <div class="col-md-auto justify-content-center">
                                            <div class="p-3 d-flex justify-content-between">
                                                <button data-prompt-msg="Are you sure you want to delete these records?"
                                                    data-display-style="modal"
                                                    data-url="<?php print_link("pesanan/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>"
                                                    class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                    <i class="fa fa-times"></i> Delete Selected
                                                </button>
                                                <div class="dropup export-btn-holder mx-1">
                                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-save"></i> Export
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                                        <a class="dropdown-item export-link-btn" data-format="print"
                                                            href="<?php print_link($export_print_link); ?>" target="_blank">
                                                            <img src="<?php print_link('assets/images/print.png') ?>"
                                                                class="mr-2" /> PRINT
                                                        </a>
                                                        <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                                        <a class="dropdown-item export-link-btn" data-format="pdf"
                                                            href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                                            <img src="<?php print_link('assets/images/pdf.png') ?>"
                                                                class="mr-2" /> PDF
                                                        </a>
                                                        <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                                        <a class="dropdown-item export-link-btn" data-format="word"
                                                            href="<?php print_link($export_word_link); ?>" target="_blank">
                                                            <img src="<?php print_link('assets/images/doc.png') ?>"
                                                                class="mr-2" /> WORD
                                                        </a>
                                                        <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                        <a class="dropdown-item export-link-btn" data-format="csv"
                                                            href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                            <img src="<?php print_link('assets/images/csv.png') ?>"
                                                                class="mr-2" /> CSV
                                                        </a>
                                                        <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                        <a class="dropdown-item export-link-btn" data-format="excel"
                                                            href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                            <img src="<?php print_link('assets/images/xsl.png') ?>"
                                                                class="mr-2" /> EXCEL
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <?php
                                            if ($show_pagination == true) {
                                                $pager = new Pagination($total_records, $record_count);
                                                $pager->route = $this->route;
                                                $pager->show_page_count = true;
                                                $pager->show_record_count = true;
                                                $pager->show_page_limit = true;
                                                $pager->limit_count = $this->limit_count;
                                                $pager->show_page_number_list = true;
                                                $pager->pager_link_range = 5;
                                                $pager->render();
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                              

                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Include status update JavaScript -->
<script src="<?php print_link('assets/js/pesanan-status.js'); ?>"></script>
<script>
    var BASE_URL = '<?php print_link(""); ?>';
</script>
<script src="<?php print_link('assets/js/pesanan-status.js'); ?>"></script>

<?php
// Fungsi untuk menentukan class badge berdasarkan status
function getStatusBadgeClass($status)
{
    switch ($status) {
        case 'Diproses':
            return 'btn-info';
        case 'Dikirim':
            return 'btn-primary';
        case 'Aktifkan Layanan':
            return 'btn-primary';
        case 'Selesai':
            return 'btn-success';
        default:
            return 'btn-secondary';
    }
}
?>

<!-- Modal untuk menampilkan bukti transfer -->
<div class="modal fade" id="buktiTransferModal" tabindex="-1" role="dialog" aria-labelledby="buktiTransferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="buktiTransferModalLabel">Bukti Transfer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="buktiTransferImg" src="" class="img-fluid" alt="Bukti Transfer">
                <div id="imageDebugInfo" style="margin-top: 10px; font-size: 12px; color: #666;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <a id="directImageLink" href="#" target="_blank" class="btn btn-primary">Buka di Tab Baru</a>
            </div>
        </div>
    </div>
</div>

<script>
    function viewBuktiTransfer(filename) {
        console.log("Opening image:", filename);
        var imgPath = '<?php print_link("uploads/buktitransfer/"); ?>' + filename;
        console.log("Full image path:", imgPath);
        
        // Set image source
        document.getElementById('buktiTransferImg').src = imgPath;
        
        // Set direct link
        document.getElementById('directImageLink').href = imgPath;
        
        // Add debug info
        document.getElementById('imageDebugInfo').innerHTML = 'Image URL: ' + imgPath;
        
        // Show modal
        $('#buktiTransferModal').modal('show');
        
        // Log if image fails to load
        document.getElementById('buktiTransferImg').onerror = function() {
            console.error("Failed to load image:", imgPath);
            document.getElementById('imageDebugInfo').innerHTML += '<br><strong style="color:red">Error loading image!</strong>';
        };
    }
</script>



















