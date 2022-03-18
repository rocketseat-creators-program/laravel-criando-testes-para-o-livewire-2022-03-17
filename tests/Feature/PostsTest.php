<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PostsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function checar_se_a_rota_existe()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
    }

    /** @test */
    public function checar_se_carregou_componente()
    {
        $this->get(route('home'))->assertSeeLivewire('posts');
    }

    /** @test */
    public function checar_se_carregou_a_view_correta()
    {
        Livewire::test('posts')
            ->assertSee('Novo Post')
            ->assertSee('Registros');
    }

    /** @test */
    public function checar_se_validacao_do_form_funciona()
    {
        Livewire::test('posts')
            ->call('salvar')
            ->assertHasErrors(['titulo' => ['required']]);
    }

    /** @test */
    public function checar_se_titulo_descricao_curtos_sao_invalidos()
    {
        Livewire::test('posts')
            ->set('titulo', 'oi')
            ->set('descricao', 'tchau')
            ->call('salvar')
            ->assertHasErrors(['titulo' => ['min'], 'descricao' => ['min']]);
    }

    /** @test */
    public function checar_se_cadastro_funciona()
    {
        Livewire::test('posts')
            ->set('titulo', 'Primeiro Post')
            ->set('descricao', 'Primeira descrição')
            ->set('publicado', 1)
            ->call('salvar')
            ->assertHasNoErrors()
            ->assertSee('Primeiro Post')
            ->assertSee('Primeira descrição')
            ->assertSee('Editar')
            ->assertSee('Excluir')
            ->assertSee('Sim');

        $this->assertDatabaseHas('posts', [
            'titulo' => 'Primeiro Post',
            'descricao' => 'Primeira descrição',
            'publicado' => 1,
        ]);
    }

    /** @test */
    public function checar_se_edicao_falha_com_id_invalido()
    {
        Livewire::test('posts')
            ->call('editar', 123)
            ->assertDontSee('Editando Post 123');
    }

    /** @test */
    public function checar_se_edicao_carrega_os_dados()
    {
        $post = Post::create([
            'titulo' => 'Post 1',
            'descricao' => 'Desc Post 1',
            'publicado' => 1,
        ]);

        Livewire::test('posts')
            ->call('editar', $post->id)
            ->assertSee('Editando Post '.$post->id)
            ->assertDontSee('Novo Post');
    }

    /** @test */
    public function checar_se_atualiza_os_dados()
    {
        $post = Post::create([
            'titulo' => 'Post 1',
            'descricao' => 'Desc Post 1',
            'publicado' => 1,
        ]);

        Livewire::test('posts')
            ->call('editar', $post->id)
            ->assertSee('Editando Post '.$post->id)
            ->set('titulo', 'Post 2')
            ->set('descricao', 'Desc Post 2')
            ->set('publicado', 0)
            ->call('salvar')
            ->assertDontSee('Editando Post '.$post->id)
            ->assertSee('Novo Post')
            ->assertSee('Post 2')
            ->assertSee('Desc Post 2')
            ->assertSee('Não')
            ;
    }

    /** @test */
    public function checar_se_excluiu_registro()
    {
        $post = Post::create([
            'titulo' => 'Post 1',
            'descricao' => 'Desc Post 1',
            'publicado' => 1,
        ]);

        Livewire::test('posts')
            ->call('excluir', $post->id)
            ->assertDontSee('Post 1')
            ->assertDontSee('Desc Post 1')
            ->assertDontSee('Sim');
    }
}
