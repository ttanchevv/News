<aside class="w-auto lg:w-1/4 bg-white shadow-2xl border-lg rounded p-4">
    <div class="space-y-8">
        <!-- Most Read & Most Commented Card -->
        <div class="bg-white shadow-lg border-2 rounded-lg p-4">
            <h2 class="text-2xl font-bold text-blue-500 mb-4 text-center">Most Read & Commented</h2>
            <div class="flex justify-center space-x-6 mb-4">
                <button id="most-read-btn" class="text-blue-500 text-sm font-semibold border-b-2 border-blue-500 px-4 py-2">
                    Most Read
                </button>
                <button id="most-commented-btn" class="text-sm text-gray-700 font-semibold hover:text-blue-500 px-4 py-2">
                    Most Commented
                </button>
            </div>
            <!-- Most Read Content -->
            <div id="most-read-content" class="mt-4 text-left">
                <h3 class="text-lg font-bold text-gray-700 mb-2">Most Read</h3>
                <ul class="space-y-2">
                    @foreach ($mostRead as $item)
                        <li>
                            <a href="{{ route('article', ['id' => $item->id]) }}" class="flex items-center space-x-4 text-blue-500 hover:text-blue-700 transition-all duration-300">
                                <!-- Малка снимка -->
                                <img src="{{ asset('images/news/' . $item->news_img) }}" alt="News Image" class="w-16 h-16 object-cover rounded-lg">
                                <!-- Текст на новината -->
                                <div class="text-gray-800">
                                    <h3 class="font-semibold text-lg">{{ $item->title }}</h3>
                                    <p class="text-sm text-gray-600">({{ $item->views }} views)</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Most Commented Content -->
            <div id="most-commented-content" class="mt-4 text-left hidden">
                <h3 class="text-lg font-bold text-gray-700 mb-2">Most Commented</h3>
                <ul class="space-y-2">
                    @foreach ($mostCommented as $item)
                        <li>
                            <a href="{{ route('article', ['id' => $item->id]) }}" class="flex items-center space-x-4 text-blue-500 hover:text-blue-700 transition-all duration-300">
                                <!-- Малка снимка -->
                                <img src="{{ asset('images/news/' . $item->news_img) }}" alt="News Image" class="w-16 h-16 object-cover rounded-lg">
                                <!-- Текст на новината -->
                                <div class="text-gray-800">
                                    <h3 class="font-semibold text-lg">{{ $item->title }}</h3>
                                    <p class="text-sm text-gray-600">({{ $item->comments_count }} comments)</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Categories Card -->
        <div class="bg-white shadow-lg rounded-lg p-4 border-2">
            <h3 class="text-xl font-bold text-blue-500 text-center mb-4">Categories</h3>
            <ul class="space-y-2 text-center font-bold">
                @foreach($cats as $catName)
                    <li>
                        <a href="{{ route('category', ['id' => $catName->id]) }}" class="text-gray-700 hover:text-gray-400">
                            {{ $catName->name }}
                        </a>
                        <hr />
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Poll -->
        <div class="bg-white shadow-lg rounded-lg p-4 border-2">
            <h3 class="text-xl font-bold text-blue-500 text-center mb-4">Анкети</h3>
            @if($poll)
                <h3 class="text-xl font-bold text-blue-500 text-center mb-4">{{ $poll->title }}</h3>
                <p class="text-sm text-gray-500 text-center mb-4">{{ $poll->description }}</p>

                @if(auth()->check())
                    @php
                        // Проверка дали потребителят вече е гласувал
                        $hasVoted = $poll->votes->where('user_id', auth()->id())->isNotEmpty();
                    @endphp

                    @if($hasVoted)
                        <!-- Резултати за логнат потребител, който вече е гласувал -->
                        <h3 class="text-lg font-semibold text-gray-700 mb-4">Results</h3>
                        <ul class="space-y-2 text-center">
                            @foreach($results as $result)
                                <li>
                                    <div class="flex justify-between">
                                        <span>{{ $result['option_text'] }}</span>
                                        <span>{{ $result['votes'] }} votes ({{ round($result['percentage'], 2) }}%)</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <!-- Формата за гласуване за логнат потребител -->
                        <form action="{{ route('votePoll', ['id' => $poll->id]) }}" method="POST" class="space-y-4">
                            @csrf
                            @foreach($poll->options as $option)
                                <div>
                                    <label>
                                        <input type="radio" name="option_id" value="{{ $option->id }}" required>
                                        {{ $option->option_text }}
                                    </label>
                                </div>
                            @endforeach

                            <button type="submit" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                                Submit Vote
                            </button>
                        </form>
                    @endif
                @else
                    <!-- Резултати за потребител, който не е логнат -->
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Results</h3>
                    <ul class="space-y-2 text-center">
                        @foreach($results as $result)
                            <li>
                                <div class="flex justify-between">
                                    <span>{{ $result['option_text'] }}</span>
                                    <span>{{ $result['votes'] }} votes ({{ round($result['percentage'], 2) }}%)</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <p class="text-sm text-gray-500 text-center mt-4">Log in to vote.</p>
                @endif
            @else
                <p class="text-sm text-gray-500 text-center">Няма активни анкети.</p>
            @endif
        </div>
    </div>
	<script>
	/** Most Read & Commented */
document.addEventListener('DOMContentLoaded', () => {
    const mostReadBtn = document.getElementById('most-read-btn');
    const mostCommentedBtn = document.getElementById('most-commented-btn');
    const mostReadContent = document.getElementById('most-read-content');
    const mostCommentedContent = document.getElementById('most-commented-content');

    mostReadBtn.addEventListener('click', () => {
        mostReadContent.classList.remove('hidden');
        mostCommentedContent.classList.add('hidden');
        mostReadBtn.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
        mostCommentedBtn.classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
        mostCommentedBtn.classList.add('text-gray-700');
    });

    mostCommentedBtn.addEventListener('click', () => {
        mostCommentedContent.classList.remove('hidden');
        mostReadContent.classList.add('hidden');
        mostCommentedBtn.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
        mostReadBtn.classList.remove('text-blue-500', 'border-b-2', 'border-blue-500');
        mostReadBtn.classList.add('text-gray-700');
    });
});
/** END Most Read & Commented */
	</script>	
</aside>
