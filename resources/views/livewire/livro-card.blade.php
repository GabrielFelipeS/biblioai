<div class="d-flex flex-wrap">
@foreach ($livros as $livro)
    <div class="card  card-primary text-center mb-3" >
        <!-- Imagem do livro com hover -->
        <div class="card-image-container position-relative" style="height: 430px; width: 300px;">
            <img src="{{ $livro['nomeDaFoto'] }}" style="width: 100%; height: 100%; object-fit: cover;" class="" alt="Imagem do Livro">

            <!-- Conteúdo que aparece no hover -->
            <div class="overlay-content position-absolute top-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center">
                <div class="card-header">
                    <h4 class="card-title mb-0">{{ $livro['nomeLivro'] }}</h4>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        {{ $livro['descricao'] }}
                     </p>
                </div>
            </div>
        </div>
    </div>
@endforeach
    @empty($livros)
        <div class="d-flex w-100 justify-content-center">
            <h5>Nenhuma recomendação para esse livro.</h5>
        </div>
    @endempty
</div>
