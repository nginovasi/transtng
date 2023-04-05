class CoreEventsHubdat {

    constructor() {
        
    }

    load(filter, search){
        var thisClass = this;

        $('#datatable').DataTable().destroy()        

        this.table = $('#datatable').DataTable({
            "serverSide": true,
            "processing": true,
            "ordering" : true,
            "paging": true,
            // "searching": false, 
            "searching": { "regex": true },
            "lengthMenu": [ [5, 10, 15, 20], [5, 10, 15, 20] ],
            "pageLength": 5,
            "searchDelay" : 500,
            "ajax": {
                "type": "POST",
                "url": url + "_load",
                "dataType": "json",
                "data": function (data) {
                    data.filter = filter
                    data.search = search

                    // console.log(thisClass);
                    // Grab form values containing user options
                    dataStart = data.start;
                    let form = {};
                    Object.keys(data).forEach(function(key) {
                        form[key] = data[key] || "";
                    });

                    // Add options used by Datatables
                    let info = { 
                        "start": data.start || 0, 
                        "length": data.length, 
                        "draw": 1
                    };

                    $.extend(form, info);
                    $.extend(form, thisClass.csrf);

                    return form;
                },
                "complete": function(response) {
                    // console.log(response);
                    // feather.replace();
                }
            },
            "columns" : thisClass.tableColumn
        }).on('init.dt', function(){
            $(this).css('width','100%');
        });

        $(document)
        .on('click', '.blue-lite', function(){
            let $this = $(this);
            let data = { id : $this.data('id') }
            $.extend(data, thisClass.csrf);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url : thisClass.url + "_blueLite",
                type : 'POST',
                data : data,
                dataType: 'json',
                success: function(result){
                    Swal.close();
                    if(result.success){
                        $('#' + result.atr.modal_body).html(result.data)
                        $('#' + result.atr.modal).modal('toggle');
                    }
                },
                error: function(){
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        })
        .on('click', '.blue-test-period', function(){
            let $this = $(this);
            let data = { id : $this.data('id') }
            $.extend(data, thisClass.csrf);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url : thisClass.url + "_blueTestPeriod",
                type : 'POST',
                data : data,
                dataType: 'json',
                success: function(result){
                    Swal.close();
                    if(result.success){
                        $('#' + result.atr.modal_body).html(result.data)
                        $('#' + result.atr.modal).modal('toggle');
                    }
                },
                error: function(){
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        })
        .on('click', '.blue-last', function(){
            let $this = $(this);
            let data = { id : $this.data('id') }
            $.extend(data, thisClass.csrf);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url : thisClass.url + "_blueLast",
                type : 'POST',
                data : data,
                dataType: 'json',
                success: function(result){
                    Swal.close();
                    if(result.success){
                        $('#' + result.atr.modal_body).html(result.data)
                        $('#' + result.atr.modal).modal('toggle');
                    }
                },
                error: function(){
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        })
        .on('click', '.blue-rfid-last', function(){
            let $this = $(this);
            let data = { id : $this.data('id') }
            $.extend(data, thisClass.csrf);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url : thisClass.url + "_bluerfidLast",
                type : 'POST',
                data : data,
                dataType: 'json',
                success: function(result){
                    Swal.close();
                    if(result.success){
                        $('#' + result.atr.modal_body).html(result.data)
                        $('#' + result.atr.modal).modal('toggle');
                    }
                },
                error: function(){
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        })
        .on('click', '.spionam-last', function(){
            let $this = $(this);
            let data = { id : $this.data('id') }
            $.extend(data, thisClass.csrf);

            Swal.fire({
                title: "",
                icon: "info",
                text: "Proses mengambil data, mohon ditunggu...",
                didOpen: function() {
                    Swal.showLoading()
                }
            });

            $.ajax({
                url : thisClass.url + "_spionamLast",
                type : 'POST',
                data : data,
                dataType: 'json',
                success: function(result){
                    Swal.close();
                    if(result.success){
                        $('#' + result.atr.modal_body).html(result.data)
                        $('#' + result.atr.modal).modal('toggle');
                    }
                },
                error: function(){
                    Swal.close();
                    Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
                }
            });
        })
    }

    datepicker(element){
        $(element).datepicker({ 
            format: 'yyyy-mm-dd',
            orientation: "bottom"
        }).on('changeDate', function(){
            $(this).datepicker('hide');
        });
    }
}