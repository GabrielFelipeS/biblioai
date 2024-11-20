<form method="GET" wire:submit.prevent="buscar">
    <h5 class="font-weight-bold mb-3">
        Descubra novos mundos: Insira seu critério para o livro e deixe suas próximas leituras escolherem você!
    </h5>
    <div class="d-flex justify-content-center mb-2">
        <div class="col-8">
            <input class="form-control" type="text" wire:model="termoBusca" placeholder="Digite o que está buscando em um livro">
        </div>
        <button type="submit" class="btn btn-primary">Buscar</button>
    </div>
</form>
