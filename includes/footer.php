
<footer>
                <p>Copyright © <?php echo DATE("Y"); ?> By Bilicsan Tec Develop By Abuubakar Mohamed (Tamer).</p>
            </footer>
        </div>
    </div>
        <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> -->


    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/feather.min.js"></script>
    <script src="../assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="../assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="../assets/plugins/apexchart/chart-data.js"></script>
    <script src="../assets/js/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/app.js"></script>
   
    
<!-- Bootstrap 4 Bundle -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../js/app.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Export to Excel',
                    className: 'btn btn-success',
                    customize: function( xlsx ) {
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        $('row:first c', sheet).attr('s', '2'); // Apply bold and center
                    }
                },
                // {
                //     extend: 'pdfHtml5',
                //     text: '<i class="fas fa-file-pdf"></i> Export to PDF',
                //     className: 'btn btn-danger',
                //     customize: function(doc) {
                //         doc.content.splice(0, 0, {
                //             text: 'Bootstrap Data Table',
                //             fontSize: 16,
                //             alignment: 'center',
                //             color: 'white',
                //             fillColor: '#007bff',
                //             margin: [0, 0, 0, 10]
                //         });
                //     }
                // },
                {
                    extend: 'print',
                    text: '<i class="fas fa-print"></i> Print Table',
                    className: 'btn btn-primary'
                }
            ]
        });
    });
</script>
<!-- Drop Down Code -->
<script>
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let input = this.value.toUpperCase();
        let items = document.querySelectorAll("#dropdownList .dropdown-item");

        items.forEach(item => {
            let text = item.textContent || item.innerText;
            item.style.display = text.toUpperCase().indexOf(input) > -1 ? "" : "none";
        });
    });

    function selectItem(element) {
        document.getElementById("searchInput").value = element.innerText;
        document.getElementById("dropdownList").classList.remove("show");
    }
</script>

<!-- Google Translate Script -->
  <script type="text/javascript">
    function googleTranslateElementInit() {
      new google.translate.TranslateElement({
        pageLanguage: 'en',
        includedLanguages: 'en,so,ar,fr',
        layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
        autoDisplay: true
      }, 'google_translate_element');
    }
  </script>
<script type="text/javascript" src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</body>

</html>