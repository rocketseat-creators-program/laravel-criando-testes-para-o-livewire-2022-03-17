<div>
    <div class="p-8 grid grid-cols-2 gap-8">
        <div class='space-y-4'>
            <h1 class='text-4xl font-bold'>Novo Post</h1>
            <form action="#" wire:submit.prevent='salvar' class='space-y-2'>
                <x-input wire:model.debounce.500ms='titulo' placeholder='Título' label='Título' />
                <x-textarea wire:model.debounce.500ms='descricao' label='Descrição' />
                <x-checkbox wire:model.debounce.500ms='publicado' left-label='Publicado' />
                <x-button primary type='submit' label='Salvar' />
            </form>
        </div>

        <div class='space-y-4'>
            <h1 class='text-4xl font-bold'>Registros</h1>
            <ul role="list" class="grid grid-cols-2 gap-4">
                @foreach ($posts as $post)
                <li class="col-span-1 bg-white rounded-lg shadow divide-y divide-gray-200">
                  <div class="w-full flex items-center justify-between p-6 space-x-6">
                    <div class="flex-1 truncate">
                      <div class="flex items-center space-x-3">
                        <h3 class="text-gray-900 text-sm font-medium truncate">{{ $post->id }} - {{ $post->titulo }}</h3>
                        <span class="flex-shrink-0 inline-block px-2 py-0.5 text-xs font-medium {{  $post->publicado ? 'text-green-800 bg-green-100' : 'text-yellow-800 bg-yellow-100'}} rounded-full">{{ $post->publicado ? 'Sim' : 'Não' }}</span>
                      </div>
                      <p class="mt-1 text-gray-500 text-sm truncate">{{ $post->descricao }}</p>
                    </div>
                  </div>
                  <div>
                    <div class="-mt-px flex divide-x divide-gray-200">
                      <div class="w-0 flex-1 flex">
                        <a href='#' wire:click.prevent='editar({{ $post->id }})' class="relative -mr-px w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-bl-lg hover:text-gray-500">
                          <x-icon name='pencil' class='w-5 h-5 text-gray-400' />
                          <span class="ml-3">Editar</span>
                        </a>
                      </div>
                      <div class="-ml-px w-0 flex-1 flex">
                        <a href='#' wire:click.prevent='excluir({{ $post->id }})' class="relative w-0 flex-1 inline-flex items-center justify-center py-4 text-sm text-gray-700 font-medium border border-transparent rounded-br-lg hover:text-gray-500">
                            <x-icon name='trash' class='w-5 h-5 text-gray-400' />
                            <span class="ml-3">Excluir</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </li>
                @endforeach
              </ul>
        </div>
    </div>
</div>
