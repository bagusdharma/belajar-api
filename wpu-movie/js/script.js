function searchMovie() {
    // tiap selesai search htmlnya dikosongin, baru dicari ulang dengan search lainnya
    $('#movie-list').html('');

    $.ajax({
        url: 'http://omdbapi.com',
        type: 'get',
        dataType: 'json',
        // kirimkan parameter yang dicari seperti pada postman
        data: {
            'apikey': 'edf07ae7',
            's': $('#search-input').val() // jquery carikan dulu id yang di input dan masukkan hasilnya sebagai val
        },
        success: function (result) {
            if (result.Response == "True") {
                var movie = result.Search;
                
                // cara for di jquery
                $.each(movie, function (i, data) {
                    $('#movie-list').append(`
                     <div class="col-md-4">
                     <div class="card mb-3">
                     <img src="`+ data.Poster + `" class="card-img-top">
                         <div class="card-body">
                         <h5 class="card-title">`+ data.Title + `</h5>
                         <h6>`+ data.Year + `</h6>    
                          <a href="#" class="card-link see-details" data-toggle="modal" data-target="#exampleModal" data-id="`+ data.imdbID + `">See Details</a>
                          </div>
                     </div>
                     </div>
                     `);

                    // pada <h6></h6> see details ditambahkan data-toggle="modal" data-target="#exampleModal" untuk menampilkan modal box

                    // dan pada class ditambahkan see details agar bisa diambil pada jquery

                });

                $('#search-input').val('');

            } else {
                $('#movie-list').html(`
                     <div class="col">
                     <h1 class="text-center"> ` + result.Error + ` </h1>
                     </div>
                 `)
            }
        }
    });
}

// jquery carikan dulu id button yang di klik. dan jalankan fungsi
$('#search-button').on('click', function () {
    searchMovie();
});

$('#search-input').on('keyup', function (event) {
    if (event.which === 13) {
        searchMovie();
    }
})

// jquery carikan id namanya movie-list, yang ketika diklik dengan class see-details
$('#movie-list').on('click', '.see-details', function () {

// $('documents').on('click', '.see-details', function () {
    
    // console.log($(this).data('id'));

    $.ajax({
        url: 'http://omdbapi.com',
        dataType: 'json',
        type: 'get',
        data: {
            'apikey': 'edf07ae7',
            'i': $(this).data('id')
        },
        success: function (movie) {
            if (movie.Response === 'True') {
                $('.modal-body').html(`
                <div class="container-fluid">
                    <div class="row">
                         <div class="col-md-4">
                            <img src="`+ movie.Poster + `" class="img-fluid">
                         </div>

                         <div class="col-md-8">
                             <ul class="list-group">
                                <li class="list-group-item"> <h3>`+ movie.Title +`</h3> </li>
                                <li class="list-group-item"> <h7> Year: `+ movie.Year +`</h7> </li>
                                <li class="list-group-item"> <h7> Released: `+ movie.Released +`</h7> </li>
                                <li class="list-group-item"> <h7> Genre: `+ movie.Genre +`</h7> </li>
                                <li class="list-group-item"> <h7> Director: `+ movie.Director +`</h7> </li>

                             </ul>
                         </div>
                    </div>
                </div>
                `)
            }
        }
    });
})