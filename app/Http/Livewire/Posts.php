<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Component;

class Posts extends Component
{
    public $post_id;
    public $titulo;
    public $descricao;
    public $publicado;
    public $posts;

    public $rules = [
        'titulo' => 'required|min:3',
        'descricao' => 'nullable|min:10',
        'publicado' => 'nullable|boolean',
    ];

    public function mount()
    {
        $this->posts = Post::all();
    }

    public function salvar()
    {
        if (empty($this->post_id)) {
            Post::create([
                'titulo' => $this->titulo,
                'descricao' => $this->descricao,
                'publicado' => empty($this->publicado) ? 0 : 1,
            ]);
        } else {
            Post::where('id', $this->post_id)
                ->update([
                    'titulo' => $this->titulo,
                    'descricao' => $this->descricao,
                    'publicado' => empty($this->publicado) ? 0 : 1,
                ]);
        }

        $this->reset(['titulo', 'descricao', 'publicado', 'post_id']);
        $this->posts = Post::all();
    }

    public function editar($id)
    {
        $post = Post::find($id);
        if (!empty($post)) {
            $this->post_id = $id;
            $this->titulo = $post->titulo;
            $this->descricao = $post->descricao;
            $this->publicado = $post->titulo;
        }
    }

    public function excluir($id)
    {
        $post = Post::find($id);
        if (!empty($post)) {
            $post->delete();
        }
        $this->posts = Post::all();
    }

    public function render()
    {
        return view('livewire.posts');
    }
}
