<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.perpus-reader {
    padding: 10px 0 25px;
}

.perpus-reader-header {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 16px;
    margin-bottom: 16px;
}

.perpus-reader-title {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 8px;
    color: #222;
}

.perpus-reader-meta {
    color: #666;
    font-size: 13px;
}

.perpus-reader-toolbar {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 12px;
    margin-bottom: 16px;
}

.perpus-reader-toolbar-left,
.perpus-reader-toolbar-right {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 8px;
}

.perpus-btn {
    display: inline-block;
    border-radius: 5px;
    padding: 8px 13px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    border: 1px solid transparent;
    cursor: pointer;
}

.perpus-btn-primary {
    color: #fff !important;
    background: #0288a7;
    border-color: #0288a7;
}

.perpus-btn-light {
    color: #0288a7 !important;
    background: #fff;
    border-color: #d7edf2;
}

.perpus-btn-dark {
    color: #fff !important;
    background: #333;
    border-color: #333;
}

.perpus-btn:disabled {
    opacity: .45;
    cursor: not-allowed;
}

.perpus-page-info {
    font-size: 13px;
    color: #555;
    font-weight: 700;
    padding: 0 6px;
}

.perpus-book-stage {
    position: relative;
    background: linear-gradient(135deg, #edf7fa, #f9fcfd);
    border: 1px solid #dcecef;
    border-radius: 14px;
    padding: 24px;
    min-height: 640px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.perpus-float-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 46px;
    height: 46px;
    border-radius: 50%;
    border: 0;
    background: rgba(2, 136, 167, .92);
    color: #fff;
    z-index: 20;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 6px 16px rgba(0, 0, 0, .18);
    transition: all .18s ease;
}

.perpus-float-nav:hover {
    background: #026f88;
    transform: translateY(-50%) scale(1.05);
}

.perpus-float-nav:disabled {
    opacity: .35;
    cursor: not-allowed;
    transform: translateY(-50%);
}

.perpus-float-prev {
    left: 14px;
}

.perpus-float-next {
    right: 14px;
}

.perpus-book-stage::before,
.perpus-book-stage::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    width: 28%;
    z-index: 5;
}

.perpus-book-stage::before {
    left: 0;
    cursor: w-resize;
}

.perpus-book-stage::after {
    right: 0;
    cursor: e-resize;
}

.perpus-book {
    position: relative;
    z-index: 10;
}

.perpus-book {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2px;
    max-width: 1120px;
    width: 100%;
    transform-origin: center;
    transition: transform .18s ease, opacity .18s ease;
}

.perpus-book.is-turning {
    opacity: .35;
    transform: scale(.985);
}

.perpus-page {
    background: #fff;
    min-height: 580px;
    border: 1px solid #d9d9d9;
    box-shadow: 0 10px 24px rgba(0, 0, 0, .14);
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    position: relative;
}

.perpus-page-left {
    border-radius: 10px 2px 2px 10px;
}

.perpus-page-right {
    border-radius: 2px 10px 10px 2px;
}

.perpus-page::after {
    content: "";
    position: absolute;
    top: 0;
    bottom: 0;
    width: 32px;
    pointer-events: none;
}

.perpus-page-left::after {
    right: 0;
    background: linear-gradient(to left, rgba(0, 0, 0, .08), rgba(255, 255, 255, 0));
}

.perpus-page-right::after {
    left: 0;
    background: linear-gradient(to right, rgba(0, 0, 0, .08), rgba(255, 255, 255, 0));
}

.perpus-page canvas {
    max-width: 100%;
    height: auto;
    display: block;
}

.perpus-page-empty {
    color: #aaa;
    font-size: 14px;
    text-align: center;
    padding: 20px;
}

.perpus-reader-loading,
.perpus-reader-empty {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 24px;
    text-align: center;
}

.perpus-reader-loading i {
    font-size: 28px;
    color: #0288a7;
    margin-bottom: 10px;
}

.perpus-reader-note {
    font-size: 12px;
    color: #777;
    margin-top: 10px;
    text-align: center;
}

@media (max-width: 991px) {
    .perpus-book-stage {
        padding: 14px;
        min-height: 520px;
    }

    .perpus-book {
        grid-template-columns: 1fr;
        max-width: 620px;
    }

    .perpus-page-right {
        display: none;
    }

    .perpus-page-left {
        border-radius: 10px;
    }

    .perpus-page-left::after {
        display: none;
    }

    .perpus-page {
        min-height: 500px;
    }
}

@media (max-width: 575px) {
    .perpus-reader-toolbar {
        align-items: stretch;
    }

    .perpus-reader-toolbar-left,
    .perpus-reader-toolbar-right {
        width: 100%;
        justify-content: center;
    }

    .perpus-btn {
        padding: 7px 10px;
        font-size: 12px;
    }

    .perpus-book-stage {
        min-height: 420px;
        padding: 10px;
    }

    .perpus-page {
        min-height: 390px;
    }

    .perpus-float-nav {
        width: 40px;
        height: 40px;
    }

    .perpus-float-prev {
        left: 8px;
    }

    .perpus-float-next {
        right: 8px;
    }
}
</style>

<div class="perpus-reader">
    <div style="margin-bottom: 15px;">
        <a href="<?= html_escape($buku->detail_url) ?>" class="perpus-btn perpus-btn-light">
            <i class="fa fa-arrow-left"></i> Kembali ke Detail Buku
        </a>

        <a href="<?= site_url('perpustakaan-digital?tab=koleksi') ?>" class="perpus-btn perpus-btn-light">
            Koleksi Buku
        </a>
    </div>

    <div class="perpus-reader-header">
        <h1 class="perpus-reader-title"><?= html_escape($buku->judul) ?></h1>

        <div class="perpus-reader-meta">
            <?php if (! empty($buku->kategori)) : ?>
            <?= html_escape($buku->kategori) ?>
            <?php endif; ?>

            <?php if (! empty($buku->sumber)) : ?>
            &nbsp; | &nbsp; Sumber: <?= html_escape($buku->sumber) ?>
            <?php endif; ?>

            &nbsp; | &nbsp; Dibaca <?= (int) $buku->dilihat + 1 ?> kali
        </div>
    </div>

    <?php if (! empty($buku->reader_url)) : ?>
    <div class="perpus-reader-toolbar">
        <div class="perpus-reader-toolbar-left">
            <button type="button" class="perpus-btn perpus-btn-light" id="btnPrevPage">
                <i class="fa fa-chevron-left"></i> Sebelumnya
            </button>

            <span class="perpus-page-info" id="pageInfo">
                Memuat...
            </span>

            <button type="button" class="perpus-btn perpus-btn-light" id="btnNextPage">
                Berikutnya <i class="fa fa-chevron-right"></i>
            </button>
        </div>

        <div class="perpus-reader-toolbar-right">
            <button type="button" class="perpus-btn perpus-btn-light" id="btnZoomOut">
                <i class="fa fa-search-minus"></i>
            </button>

            <button type="button" class="perpus-btn perpus-btn-light" id="btnZoomIn">
                <i class="fa fa-search-plus"></i>
            </button>

            <a href="<?= html_escape($buku->reader_url) ?>" target="_blank" class="perpus-btn perpus-btn-dark">
                <i class="fa fa-file-pdf-o"></i> Buka PDF
            </a>
        </div>
    </div>

    <div class="perpus-reader-loading" id="readerLoading">
        <i class="fa fa-spinner fa-spin"></i>
        <div>Memuat buku...</div>
    </div>

    <div class="perpus-book-stage" id="bookStage" style="display:none;">
        <button type="button" class="perpus-float-nav perpus-float-prev" id="btnFloatPrev" title="Halaman sebelumnya">
            <i class="fa fa-chevron-left"></i>
        </button>

        <button type="button" class="perpus-float-nav perpus-float-next" id="btnFloatNext" title="Halaman berikutnya">
            <i class="fa fa-chevron-right"></i>
        </button>

        <div class="perpus-book" id="bookWrapper">
            <div class="perpus-page perpus-page-left" id="leftPage">
                <div class="perpus-page-empty">Halaman kiri</div>
            </div>

            <div class="perpus-page perpus-page-right" id="rightPage">
                <div class="perpus-page-empty">Halaman kanan</div>
            </div>
        </div>
    </div>

    <div class="perpus-reader-note">
        Gunakan tombol berikutnya/sebelumnya untuk membaca halaman. Pada layar kecil, buku ditampilkan satu halaman.
    </div>
    <?php else : ?>
    <div class="perpus-reader-empty">
        <h3>File PDF belum tersedia.</h3>
        <p>
            Buku ini belum memiliki file PDF yang dapat dibaca di website desa.
            Silakan hubungi admin desa untuk melengkapi file buku.
        </p>

        <a href="<?= html_escape($buku->detail_url) ?>" class="perpus-btn perpus-btn-primary">
            Kembali ke Detail Buku
        </a>
    </div>
    <?php endif; ?>
</div>

<?php if (! empty($buku->reader_url)) : ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
(function() {
    var pdfUrl = "<?= html_escape($buku->reader_url) ?>";
    var pdfDoc = null;
    var currentPage = 1;
    var totalPages = 0;
    var scale = 1.15;
    var isRendering = false;

    var loading = document.getElementById('readerLoading');
    var stage = document.getElementById('bookStage');
    var book = document.getElementById('bookWrapper');
    var leftPage = document.getElementById('leftPage');
    var rightPage = document.getElementById('rightPage');
    var pageInfo = document.getElementById('pageInfo');

    var btnPrev = document.getElementById('btnPrevPage');
    var btnNext = document.getElementById('btnNextPage');
    var btnFloatPrev = document.getElementById('btnFloatPrev');
    var btnFloatNext = document.getElementById('btnFloatNext');
    var btnZoomIn = document.getElementById('btnZoomIn');
    var btnZoomOut = document.getElementById('btnZoomOut');

    var touchStartX = 0;
    var touchStartY = 0;

    function isMobileLayout() {
        return window.innerWidth <= 991;
    }

    function clearPage(container) {
        container.innerHTML = '';
    }

    function setEmptyPage(container, text) {
        container.innerHTML = '<div class="perpus-page-empty">' + text + '</div>';
    }

    function renderPdfPage(pageNumber, container) {
        clearPage(container);

        if (pageNumber > totalPages) {
            setEmptyPage(container, 'Selesai');
            return Promise.resolve();
        }

        return pdfDoc.getPage(pageNumber).then(function(page) {
            var viewport = page.getViewport({
                scale: scale
            });
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            container.appendChild(canvas);

            return page.render({
                canvasContext: context,
                viewport: viewport
            }).promise;
        });
    }

    function updateInfo() {
        var rightNumber = isMobileLayout() ? currentPage : Math.min(currentPage + 1, totalPages);

        if (isMobileLayout() || currentPage === rightNumber) {
            pageInfo.textContent = 'Halaman ' + currentPage + ' dari ' + totalPages;
        } else {
            pageInfo.textContent = 'Halaman ' + currentPage + '-' + rightNumber + ' dari ' + totalPages;
        }

        var disablePrev = currentPage <= 1;
        var disableNext = isMobileLayout() ?
            currentPage >= totalPages :
            currentPage + 1 >= totalPages;

        btnPrev.disabled = disablePrev;
        btnNext.disabled = disableNext;

        if (btnFloatPrev) {
            btnFloatPrev.disabled = disablePrev;
        }

        if (btnFloatNext) {
            btnFloatNext.disabled = disableNext;
        }
    }

    function renderBook() {
        if (!pdfDoc || isRendering) {
            return;
        }

        isRendering = true;
        book.classList.add('is-turning');

        var leftNumber = currentPage;
        var rightNumber = currentPage + 1;

        if (isMobileLayout()) {
            rightPage.style.display = 'none';

            renderPdfPage(leftNumber, leftPage).then(function() {
                updateInfo();
                book.classList.remove('is-turning');
                isRendering = false;
            });

            return;
        }

        rightPage.style.display = '';

        Promise.all([
            renderPdfPage(leftNumber, leftPage),
            renderPdfPage(rightNumber, rightPage)
        ]).then(function() {
            updateInfo();
            book.classList.remove('is-turning');
            isRendering = false;
        });
    }

    function nextPage() {
        if (isRendering) {
            return;
        }

        if (isMobileLayout()) {
            if (currentPage < totalPages) {
                currentPage += 1;
                renderBook();
            }
        } else {
            if (currentPage + 1 < totalPages) {
                currentPage += 2;
                renderBook();
            }
        }
    }

    function prevPage() {
        if (isRendering) {
            return;
        }

        if (isMobileLayout()) {
            if (currentPage > 1) {
                currentPage -= 1;
                renderBook();
            }
        } else {
            if (currentPage > 1) {
                currentPage -= 2;
                if (currentPage < 1) {
                    currentPage = 1;
                }
                renderBook();
            }
        }
    }

    function zoomIn() {
        if (scale < 2.2) {
            scale += 0.15;
            renderBook();
        }
    }

    function zoomOut() {
        if (scale > 0.7) {
            scale -= 0.15;
            renderBook();
        }
    }

    function showError() {
        loading.innerHTML =
            '<h3>PDF gagal dimuat.</h3><p>File PDF tidak dapat dibaca oleh browser. Coba buka PDF langsung melalui tombol “Buka PDF”.</p>';
    }

    if (typeof pdfjsLib === 'undefined') {
        loading.innerHTML =
            '<h3>PDF.js gagal dimuat.</h3><p>Library pembaca PDF tidak tersedia. Pastikan koneksi internet aktif atau simpan PDF.js secara lokal.</p>';
        return;
    }

    pdfjsLib.GlobalWorkerOptions.workerSrc =
        'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';

    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        pdfDoc = pdf;
        totalPages = pdf.numPages;

        loading.style.display = 'none';
        stage.style.display = 'flex';

        renderBook();
    }).catch(function(error) {
        console.error(error);
        showError();
    });

    btnPrev.addEventListener('click', prevPage);
    btnNext.addEventListener('click', nextPage);

    if (btnFloatPrev) {
        btnFloatPrev.addEventListener('click', function(event) {
            event.stopPropagation();
            prevPage();
        });
    }

    if (btnFloatNext) {
        btnFloatNext.addEventListener('click', function(event) {
            event.stopPropagation();
            nextPage();
        });
    }

    btnZoomIn.addEventListener('click', zoomIn);
    btnZoomOut.addEventListener('click', zoomOut);

    stage.addEventListener('click', function(event) {
        if (event.target.closest('button') || event.target.closest('a')) {
            return;
        }

        var rect = stage.getBoundingClientRect();
        var clickX = event.clientX - rect.left;
        var middle = rect.width / 2;

        if (clickX < middle) {
            prevPage();
        } else {
            nextPage();
        }
    });

    stage.addEventListener('touchstart', function(event) {
        if (!event.touches || event.touches.length === 0) {
            return;
        }

        touchStartX = event.touches[0].clientX;
        touchStartY = event.touches[0].clientY;
    }, {
        passive: true
    });

    stage.addEventListener('touchend', function(event) {
        if (!event.changedTouches || event.changedTouches.length === 0) {
            return;
        }

        var touchEndX = event.changedTouches[0].clientX;
        var touchEndY = event.changedTouches[0].clientY;

        var deltaX = touchEndX - touchStartX;
        var deltaY = touchEndY - touchStartY;

        if (Math.abs(deltaX) < 60) {
            return;
        }

        if (Math.abs(deltaX) < Math.abs(deltaY)) {
            return;
        }

        if (deltaX < 0) {
            nextPage();
        } else {
            prevPage();
        }
    }, {
        passive: true
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'ArrowLeft') {
            prevPage();
        }

        if (event.key === 'ArrowRight') {
            nextPage();
        }
    });

    var resizeTimer = null;

    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);

        resizeTimer = setTimeout(function() {
            renderBook();
        }, 250);
    });
})();
</script>
<?php endif; ?>