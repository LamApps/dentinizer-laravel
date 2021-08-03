{{ csrf_field() }}
<?php if($type=='quiz') : ?>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="hidden" name="is_creation" value="0">
            <input type="hidden" name="id_quiz" value="{{ $quiz ? $quiz->id : 0 }}">
            <label class="form-label">{{ __('locale.category') }}</label>
            <select name="FILTER_CATEGORY" class="form-control form-control-sm" id="FILTER_CATEGORY" required>
                @foreach ($category as $c)
                    <option value="{{ $c->id }}" <?php if ($quiz != null && $c->id == $quiz->category->id) {
    echo 'selected="selected"';
} ?>>
                        {{ $c->name }}
                    </option>
                @endforeach

            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.name') }}</label>
            <input type="text" value="{{ $quiz ? $quiz->name : '' }}" name="name" class="form-control form-control-sm"
                required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.isActive') }}</label>
            <input type="text" id="is_active" name="is_active"
                value="{{ $quiz && $quiz->isActive == 1 ? 'yes' : 'no' }}"
                class="form-control form-control-sm datepicker">
        </div>
    </div>

</div>


<?php elseif($type=='question') : ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="hidden" name="is_creation" value="0">
            <input type="hidden" name="id_question" value="{{ $question ? $question->id : 0 }}">
            <label class="form-label">{{ __('locale.quizz') }}</label>
            <select name="FILTER_QUIZ" class="form-control form-control-sm" id="FILTER_QUIZ" required
                placeholder="- QUIZZES -">
                @foreach ($quizzes as $quiz)
                    <option value="{{ $quiz->id }}" <?php if ($question != null && $quiz->id == $question->quiz->id) {
    echo 'selected="selected"';
} ?>>
                        {{ $quiz->name }}
</option>
                @endforeach

            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.text') }}</label>
            <input type="text" value="{{ $question ? $question->text : '' }}" name="text"
                class="form-control form-control-sm" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.sort') }}</label>
            <input type="text" value="{{ $question ? $question->sort : '' }}" name="sort"
                class="form-control form-control-sm" required>
        </div>
    </div>

</div>

<?php  elseif($type=='category'):?>

<input type="hidden" name="id_category" value="{{ $category ? $category->id : 0 }}">

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.code') }}</label>
            <input type="text" value="{{ $category ? $category->code : '' }}" name="code"
                class="form-control form-control-sm" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.name') }}</label>
            <input type="text" value="{{ $category ? $category->name : '' }}" name="name"
                class="form-control form-control-sm" required>
        </div>
    </div>

</div>
<?php elseif($type=='answer') : ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="hidden" name="is_creation" value="0">
            <input type="hidden" name="id_answer" value="{{ $answer ? $answer->id : 0 }}">
            <label class="form-label">{{ __('locale.question') }}</label>
            <select name="FILTER_QUESTION" class="form-control form-control-sm" id="FILTER_QUESTION" required
                placeholder="- QUESTION-">
                @foreach ($questions as $c)
                    <option value="{{ $c->id }}" <?php if ($answer != null && $c->id == $answer->question->id) {
    echo 'selected="selected"';
} ?>>
                        {{ $c->text }}
                    <option>
                @endforeach

            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.answer') }}</label>
            <input type="text" value="{{ $answer ? $answer->text : '' }}" name="text"
                class="form-control form-control-sm" required>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.is_true') }}</label>
            <input type="text" id="is_true" name="is_true"
                value="{{ $answer && $answer->is_true == 1 ? 'yes' : 'no' }}"
                class="form-control form-control-sm datepicker">
        </div>
    </div>

</div>
<?php elseif($type=='test') : ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="hidden" name="is_creation" value="0">
            <input type="hidden" name="id_test" value="{{ $test ? $test->id : 0 }}">
            <label class="form-label">{{ __('locale.doctor') }}</label>
            <select name="FILTER_DOCTORS" class="form-control form-control-sm" id="FILTER_DOCTORS" required
                placeholder="- DOCTORS-">
                <option value=0>-- select  --</option>
                @foreach ($doctors as $c)
                    <option value="{{ $c->user_id }}" <?php if ($test != null && $c->user_id == $test->user_id) {
    echo 'selected="selected"';
} ?>>
                        {{ $c->user->name }}
                    <option>
                @endforeach

            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.quizz') }}</label>
            <select name="FILTER_QUIZ" class="form-control form-control-sm" id="FILTER_QUIZZ" required
                placeholder="- QUIZ-">
                <option value=0>-- select  --</option>
                @foreach ($quizzes as $c)
                    <option value="{{ $c->id }}" <?php if ($test != null && $c->id == $test->quizz_id) {
    echo 'selected="selected"';
} ?>>
                        {{ $c->name }}
                    <option>
                @endforeach

            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.status') }}</label>
            <select name="status" class="form-control form-control-sm" id="status" required
                placeholder="-status-">
                <option value=0>-- select  --</option>
                <?php if($test!= null) : ?>
               <option value="finished" <?php if ($test != null &&$test->status == "finished") { echo 'selected="selected"';} ?>> finished</option>
                <option value="in progress" <?php if ($test != null &&$test->status == "in progress") { echo 'selected="selected"';} ?>> in progress</option>
                <option value="not completed" <?php if ($test != null &&$test->status == "not completed") { echo 'selected="selected"';} ?>> not completed</option>
                <?php else : ?>
                <option value="to pass" <?php if ($test != null &&$test->status == "to pass") { echo 'selected="selected"';} ?>> to pass </option>
                <?php endif ?> 
            </select>
        </div>
    </div>

</div>





<?php endif ?>
