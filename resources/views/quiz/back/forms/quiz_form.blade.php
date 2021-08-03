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
            <label class="form-label">{{ __('locale.quizz') }}</label>
            <select name="FILTER_QUIZ" class="form-control form-control-sm" id="FILTER_QUiz" required
                placeholder="- QUIZ-">
                <option value="0">--select Quiz--</option>
                @foreach ($quizzes as $c)
                    <option value="{{ $c->id }}" <?php if ($answer != null && $c->id == $answer->question->quizz_id) {
    echo 'selected="selected"';
} ?>>
                        {{ $c->name }}
                    </option>
                @endforeach

            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.question') }}</label>
            <select name="FILTER_QUESTION" class="form-control form-control-sm" id="FILTER_QUESTION" required
                placeholder="- QUESTIONS-">
                <option value="0">--select Question--</option>
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
        <label class="form-label">{{ __('locale.is_true') }}</label>
        <select name="is_true" class="form-control form-control-sm" id="FILTER_QUESTION" required
            placeholder="-is true-">
            <option value="yes">yes</option>
            <option value="no">no</option>
        </select>

    </div>
</div>
</div>



<script>
    $('#FILTER_QUiz').on('change', function() {
        //alert( this.value );
        //var dept_id= this.value;
        loadQuestions('FILTER_QUESTION', 0);
    });

    //loadDoctors('sel_doc', 0);

    function loadQuestions(select_id, selected_value = 0) {
        var quiz_id = $('#FILTER_QUiz').val();
        $('#' + select_id).empty();
        $.ajax({
            url: '/filterQuestion/' + quiz_id,
            dataType: 'json',
            success: function(response) {
                var array = response;
                if (array != '') {
                    for (i in array) {
                        $('#' + select_id).append("<option value='" + array[i].id + "'>" + array[i].name +
                            "</option>");
                    }
                }
            }
        }).done(function() {
            if (selected_value != 0 && selected_value != '') {
                $('#' + select_id + ' option[value="' + selected_value + '"]').attr('selected', 'selected');
            }
        });
    }
</script>
<?php elseif($type=='test') : ?>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <input type="hidden" name="is_creation" value="0">
            <input type="hidden" name="id_test" value="{{ $test ? $test->id : 0 }}">
            <label class="form-label">{{ __('locale.doctor') }}</label>
            <select name="FILTER_DOCTORS" class="form-control form-control-sm" id="FILTER_DOCTORS" required
                placeholder="- DOCTORS-">
                <option value=0>-- select --</option>
                @foreach ($doctors as $c)
                    <option value="{{ $c->user_id }}" <?php if ($test != null && $c->user_id == $test->user_id) {
    echo 'selected="selected"';
} ?>>
                        {{ $c->user->name }}
                    </option>
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
                <option value=0>-- select --</option>
                @foreach ($quizzes as $c)
                    <option value="{{ $c->id }}" <?php if ($test != null && $c->id == $test->quizz_id) {
    echo 'selected="selected"';
} ?>>
                        {{ $c->name }}
</option>
                @endforeach

            </select>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label class="form-label">{{ __('locale.status') }}</label>
            <select name="status" class="form-control form-control-sm" id="status" required placeholder="-status-">
                <option value=0>-- select --</option>
                <?php if($test!= null) : ?>
                <option value="finished" <?php if ($test != null && $test->status == 'finished') {
    echo 'selected="selected"';
} ?>> finished</option>
                <option value="in_progress" <?php if ($test != null && $test->status == 'in_progress') {
    echo 'selected="selected"';
} ?>> in progress</option>
                <?php else : ?>
                <option value="to_pass" <?php if ($test != null && $test->status == 'to_pass') {
    echo 'selected="selected"';
} ?>> to pass </option>
                <?php endif ?>
            </select>
        </div>
    </div>

</div>





<?php endif ?>
