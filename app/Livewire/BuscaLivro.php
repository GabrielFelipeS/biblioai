<?php

namespace App\Livewire;

use App\Models\Livro;
use Exception;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class BuscaLivro extends Component
{
    public $termoBusca;
    private $token;
    private $ultima_sugestao;

    public function __construct()
    {
        $this->token = getenv('OPENAI_API_KEY');
    }

    public function buscar()
    {
        if(empty($this->termoBusca) || strlen($this->termoBusca) <= 3) {
            $livros =  Livro::all();
            $ultima_sugestao = json_encode($livros);
            $this->dispatch('livros-buscados',$livros);
            return;
        }

        $data = $this->buscarSugestoes();

        $livros = [];

//        dump($data);

        foreach ($data as $item) {
            $foto = $this->buscarFoto($item);

            if(empty($foto)) {
                continue;
            }
//            dump($item);

            $livro = Livro::whereRaw('LOWER(nomeLivro) = ?', [strtolower($item['nome'])])->first();

            if (!$livro) {
                // Se o registro não for encontrado, cria um novo
                $livro = Livro::create([
                    'nomeLivro' => $item['nome'],
                    'descricao' => $item['descricao'] ?? null,
                    'ISBN' => $item['isbn'] ?? null,
                    'nomeDaFoto' => $foto ?? 'media/not-found.jpg',
                ]);
            }

            if ($livro->nomeDaFoto === 'media/not-found.jpg' && $foto !== 'media/not-found.jpg') {
                $livro->update(['nomeDaFoto' => $foto]);
            }
            $livros[] = $livro;
        }

        $this->dispatch('livros-buscados',$livros);
    }

    private function buscarSugestoes() {
         $response = Http::withHeaders([
            'Authorization' => "Bearer $this->token",
        ])->post('https://api.openai.com/v1/chat/completions', [
             'model' => 'gpt-4o-mini',
             "temperature" => 0.0,
             "response_format" => [
                 'type' => 'json_schema',
                 'json_schema' => [
                     'name' => 'books_schema',
                     'schema' => [
                         'type' => 'object',
                         'properties' => [
                             'books' => [
                                 'description' => 'The list suggestions books',
                                 'type' => 'string',
                             ],
                         ],
                         'additionalProperties' => false,
                     ],
                 ],
             ],
        'messages' => [
                 [
                     'role' => 'system',
                     'content' =>
                     "Sou um assistente especializado em livros.
                     Quando você fornecer o nome de um livro, eu pesquisarei em fontes confiáveis e recomendarei vários livros semelhantes com base em temas, estilo ou autor.
                     Garantirei que o ISBN retornado seja correto.
                    1. Procure informações em fontes confiáveis como Google Books.,
                    2. Retorne uma lista de livros semelhantes, com base em temas, estilo ou autor do livro solicitado.,
                    3. Certifique-se de que o campo \'isbn\' contém o ISBN correto, validando-o na google books.
                    4. Retorne a resposta como uma lista de objetos JSON, onde cada objeto contém os campos: 'nome', 'descricao', 'authores' e 'isbn'.
                    5. Use tanto livros tirados da internet, quanto a ultima sugestão: $this->ultima_sugestao
                    6. Certifique-se de não devolver o livro usado pedido.
                    "
                 ],
                 [
                     'role' => 'user',
                     'content' => "Me recomende livros seguindo a seguintes intrução ou livros, por favor note que mais de um livro pode ser passado, não quero que retorne livros que foram passados para dar sugestão: \'$this->termoBusca\'"
                 ]
             ]
        ]);

         $dados = $response->json();

        $content = $dados['choices'][0]['message']['content'];

        $livros = json_decode($content, true);

        return $livros['books'];
    }

    private function buscarFoto($livro) {
        $isbn = $livro['isbn'];
        $title = $livro['nome'];
        $authores = $livro['authores'];

//        $apiUrl = "https://www.googleapis.com/books/v1/volumes?q=isbn:$isbn";
        $query = urlencode("intitle:$title+inauthor:$authores");
        $apiUrl = "https://www.googleapis.com/books/v1/volumes?q=$query&fields=items(volumeInfo(title,authors,imageLinks/thumbnail))";

        $response = Http::get($apiUrl);
//        dump($response);

        $data = $response->json();
//        dump($data);

        $photo =  'media/not-found.jpg';
        try {
            for($i = 0, $size = count( $data['items']); $i < $size; $i++) {
                try {
                    $photo = $data['items'][$i]['volumeInfo']['imageLinks']['thumbnail'];
                    return $photo;
                } catch (Exception $e) {
                    $photo = 'media/not-found.jpg';
                }
            }
        } catch (Exception $e) {
            $photo = 'media/not-found.jpg';
        }

        return $photo;
    }

    public function render()
    {
        return view('livewire.busca-livro');
    }

}
