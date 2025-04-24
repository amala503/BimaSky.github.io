<?php
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pelanggan/add");
$can_edit = ACL::is_allowed("pelanggan/edit");
$can_view = ACL::is_allowed("pelanggan/view");
$can_delete = ACL::is_allowed("pelanggan/delete");
?>
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
                        <h4 class="record-title">Pelanggan</h4>
                    </div>
                    <div class="col-sm-3 ">
                        <?php if ($can_add) { ?>
                            <a class="btn btn btn-primary my-1" href="<?php print_link("pelanggan/add") ?>">
                                <i class="fa fa-plus"></i>
                                Add New Pelanggan
                            </a>
                        <?php } ?>
                    </div>
                    <div class="col-sm-4 ">
                        <form class="search" action="<?php print_link('pelanggan'); ?>" method="get">
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
                                                <a class="text-decoration-none" href="<?php print_link('pelanggan'); ?>">
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
                                                <a class="text-decoration-none" href="<?php print_link('pelanggan'); ?>">
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
            <!-- Modal Bootstrap -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Detail Informasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBodyContent">
                <!-- Konten akan dimasukkan melalui JavaScript -->
            </div>
        </div>
    </div>
</div>

            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this::display_page_errors(); ?>
                    <div class=" animated fadeIn page-content">
                        <div id="pelanggan-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-striped table-sm text-left">
                                    <thead class="table-header bg-light">
                                        <tr>
                                            <?php if ($can_delete) { ?>
                                                <th class="td-checkbox">
                                                    <label class="custom-control custom-checkbox custom-control-inline">
                                                        <input class="toggle-check-all custom-control-input"
                                                            type="checkbox" />
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </th>
                                            <?php } ?>
                                            <th class="td-sno">#</th>
                                            <th class="td-id"> Id</th>
                                            <th class="td-status text-center"> Status</th>
                                            <th class="td-jenis_bisnis"> Jenis Bisnis</th>
                                            <th class="td-kategori_bisnis"> Kategori Bisnis</th>
                                            <th class="td-nama_perusahaan"> Nama Perusahaan</th>
                                            <th class="td-nomor_npwp"> Nomor Npwp</th>
                                            <th class="td-no_telepon"> No Telepon</th>
                                            <th class="td-password"> Password</th>
                                            <th class="td-sumber_informasi"> Sumber Informasi</th>
                                            <th class="td-email_perusahaan"> Email Perusahaan</th>
                                            <th class="td-username"> Username</th>
                                            <th class="td-pic_perusahaan"> Pic Perusahaan</th>
                                            <th class="td-alamat_perusahaan"> Alamat Perusahaan</th>

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
                                                    <?php if ($can_delete) { ?>
                                                        <th class=" td-checkbox">
                                                            <label class="custom-control custom-checkbox custom-control-inline">
                                                                <input class="optioncheck custom-control-input" name="optioncheck[]"
                                                                    value="<?php echo $data['id'] ?>" type="checkbox" />
                                                                <span class="custom-control-label"></span>
                                                            </label>
                                                        </th>
                                                    <?php } ?>
                                                    <th class="td-sno"><?php echo $counter; ?></th>
                                                    <td class="td-id"><a
                                                            href="<?php print_link("pelanggan/view/$data[id]") ?>"><?php echo $data['id']; ?></a>
                                                    </td>
                                                    <td class="td-status">
                                                        <?php if ($data['status'] == 'approve'): ?>
                                                            <span class="text-success"><strong><?php echo $data['status']; ?></strong></span>
                                                        <?php elseif ($data['status'] == 'pending'): ?>
                                                            <span class="text-danger"><strong><?php echo $data['status']; ?></strong></span>
                                                        <?php else: ?>
                                                            <?php echo $data['status']; ?>
                                                        <?php endif; ?>
                                                        <?php if ($data['status'] != 'approve' && $can_edit): ?>
                                                            <a class="btn btn-sm btn-success" href="<?php print_link("pelanggan/approve/".$data['id']); ?>" title="Approve">
                                                                <i class="fa fa-check"></i> Approve
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="td-jenis_bisnis">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['jenis_bisnis']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="jenis_bisnis" data-title="Enter Jenis Bisnis"
                                                                data-placement="left" data-toggle="click" data-type="text"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['jenis_bisnis']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-kategori_bisnis">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['kategori_bisnis']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="kategori_bisnis" data-title="Enter Kategori Bisnis"
                                                                data-placement="left" data-toggle="click" data-type="text"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['kategori_bisnis']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-nama_perusahaan">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['nama_perusahaan']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="nama_perusahaan" data-title="Enter Nama Perusahaan"
                                                                data-placement="left" data-toggle="click" data-type="text"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['nama_perusahaan']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-nomor_npwp">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['nomor_npwp']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="nomor_npwp" data-title="Enter Nomor Npwp"
                                                                data-placement="left" data-toggle="click" data-type="text"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['nomor_npwp']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-no_telepon">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['no_telepon']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="no_telepon" data-title="Enter No Telepon"
                                                                data-placement="left" data-toggle="click" data-type="text"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['no_telepon']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-password">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['password']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="password" data-title="Enter Password"
                                                                data-placement="left" data-toggle="click" data-type="password"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['password']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-sumber_informasi">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['sumber_informasi']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="sumber_informasi" data-title="Enter Sumber Informasi"
                                                                data-placement="left" data-toggle="click" data-type="text"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['sumber_informasi']; ?>
                                                        </span>
                                                    </td>
                                                    <td class="td-email_perusahaan"><a
                                                            href="<?php print_link("mailto:$data[email_perusahaan]") ?>"><?php echo $data['email_perusahaan']; ?></a>
                                                    </td>
                                                    <td class="td-username">
                                                        <span <?php if ($can_edit) { ?>
                                                                data-value="<?php echo $data['username']; ?>"
                                                                data-pk="<?php echo $data['id'] ?>"
                                                                data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
                                                                data-name="username" data-title="Enter Username"
                                                                data-placement="left" data-toggle="click" data-type="text"
                                                                data-mode="popover" data-showbuttons="left" class="is-editable"
                                                            <?php } ?>>
                                                            <?php echo $data['username']; ?>
                                                        </span>
                                                    </td>
                                                    <!-- Kolom PIC Perusahaan -->
                                                    <td class="td-pic_perusahaan">
    <?php if (!empty($data['pic_perusahaan'])): ?>
        <span <?php if ($can_edit) { ?>
            data-value="<?php echo $data['pic_perusahaan']; ?>"
            data-pk="<?php echo $data['id'] ?>"
            data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
            data-name="pic_perusahaan" data-title="Enter Pic Perusahaan"
            data-placement="left" data-toggle="click" data-type="text"
            data-mode="popover" data-showbuttons="left" class="is-editable"
        <?php } ?>></span>
    <?php endif; ?>

    <!-- Tombol Detail Pic Perusahaan -->
    <button class="btn btn-sm btn-info detail-btn" 
        onclick="window.location.href='<?php echo print_link("pic_perusahaan/view/" . urlencode($data['id'])); ?>'">
        Detail pic
    </button>
</td>

                                                    <!-- Kolom Alamat Perusahaan -->
<td class="td-alamat_perusahaan">
    <?php if (!empty($data['alamat_perusahaan'])): ?>
        <span <?php if ($can_edit) { ?>
            data-value="<?php echo $data['alamat_perusahaan']; ?>"
            data-pk="<?php echo $data['id'] ?>"
            data-url="<?php print_link("pelanggan/editfield/" . urlencode($data['id'])); ?>"
            data-name="alamat_perusahaan" data-title="Enter Alamat Perusahaan"
            data-placement="left" data-toggle="click" data-type="text"
            data-mode="popover" data-showbuttons="left" class="is-editable"
        <?php } ?>></span>
    <?php endif; ?>
    <button class="btn btn-sm btn-info detail-btn" 
        onclick="window.location.href='<?php echo print_link("alamat_perusahaan/view/" . urlencode($data['id'])); ?>'">
        Detail alamat
    </button>
</td>

                                                    <th class="td-btn">
                                                        <?php if ($can_view) { ?>
                                                            <a class="btn btn-sm btn-success has-tooltip" title="View Record"
                                                                href="<?php print_link("pelanggan/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                        <?php } ?>
                                                        <?php if ($can_edit) { ?>
                                                            <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record"
                                                                href="<?php print_link("pelanggan/edit/$rec_id"); ?>">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                        <?php } ?>
                                                        <?php if ($can_delete) { ?>
                                                            <a class="btn btn-sm btn-danger has-tooltip record-delete-btn"
                                                                title="Delete this record"
                                                                href="<?php print_link("pelanggan/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>"
                                                                data-prompt-msg="Are you sure you want to delete this record?"
                                                                data-display-style="modal">
                                                                <i class="fa fa-times"></i>
                                                                Delete
                                                            </a>
                                                        <?php } ?>
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
                                                <?php if ($can_delete) { ?>
                                                    <button data-prompt-msg="Are you sure you want to delete these records?"
                                                        data-display-style="modal"
                                                        data-url="<?php print_link("pelanggan/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>"
                                                        class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                        <i class="fa fa-times"></i> Delete Selected
                                                    </button>
                                                <?php } ?>
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
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detailButtons = document.querySelectorAll('.detail-btn');

        detailButtons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id'); 
                const type = this.getAttribute('data-type'); // alamat atau pic
                
                // Ubah judul modal sesuai jenis informasi
                if (type === "alamat") {
                    document.getElementById('modalTitle').innerText = "Detail Alamat Perusahaan";
                } else {
                    document.getElementById('modalTitle').innerText = "Detail PIC Perusahaan";
                }

                // Ambil data menggunakan AJAX
                fetch(`get_detail.php?id=${id}&type=${type}`)
                    .then(response => response.json())
                    .then(data => {
                        let content = "";
                        if (type === "alamat") {
                            content = `
                                <strong>Provinsi:</strong> ${data.provinsi}<br>
                                <strong>Kabupaten/Kota:</strong> ${data.kabupaten_kota}<br>
                                <strong>Kecamatan:</strong> ${data.kecamatan}<br>
                                <strong>Kelurahan/Desa:</strong> ${data.kelurahan_desa}<br>
                                <strong>RT/RW:</strong> ${data.rt_rw}<br>
                                <strong>Detail Alamat:</strong> ${data.detail_alamat}<br>
                                <strong>Link Maps:</strong> <a href="${data.link_maps}" target="_blank">Lihat di Maps</a>
                            `;
                        } else {
                            content = `
                                <strong>Nama PIC:</strong> ${data.nama_pic}<br>
                                <strong>Jabatan:</strong> ${data.jabatan}<br>
                                <strong>Departemen:</strong> ${data.departemen}<br>
                                <strong>No Ponsel:</strong> ${data.no_ponsel}<br>
                                <strong>NIK:</strong> ${data.nik}<br>
                                <strong>Email:</strong> ${data.email}<br>
                                <strong>Dokumen Legalitas:</strong> <a href="${data.dokumen_legalitas}" target="_blank">Lihat Dokumen</a><br>
                                <strong>Foto Akta Pendirian:</strong> <img src="${data.foto_akta_pendirian}" width="100"><br>
                                <strong>Foto NIB ISP:</strong> <img src="${data.foto_nib_isp}" width="100">
                            `;
                        }

                        document.getElementById('modalBodyContent').innerHTML = content;

                        // Tampilkan modal
                        $('#detailModal').modal('show');
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });
        });
    });
</script>
