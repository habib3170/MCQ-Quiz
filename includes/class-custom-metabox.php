<?php
defined( 'ABSPATH' ) || exit;

class Quiz_Meta_boxes {
    /**
     * class constructor
     * @since 1.0.0
     */
    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'mcq_register_meta_box' ) );
        add_action( 'save_post', array( $this, 'mcq_save_meta' ),  10, 3 );
    }

    /**
     * MCQ Register Meta box functions
     * @since 1.0.0
     */
    public function mcq_register_meta_box() {
        add_meta_box('mcq-quiz-questions', __('Select Quiz Questions', 'mcq-quiz'), array($this, 'mcq_add_quiz_questions'), array('mcq-quiz'), 'normal', 'high');
        add_meta_box( 'mcq-quiz-shortcode', 'MCQ Quiz Shortcode', array($this, 'mcq_quiz_shortcode_metabox'), array('mcq-quiz'), 'side', 'high' );
        add_meta_box( 'mcq-question-answers', __( 'Add MCQ Question Answers', 'mcq-quiz' ), array( $this, 'mcq_add_question_answers' ), array( 'mcq-question' ), 'normal', 'high' );
    }

    /**
     * Add quiz questions.
     *
     * @param WP_Post $post Post_Object
     *
     * @since 1.0.0
     */
    public function mcq_add_quiz_questions( $post ) {
        $value = get_post_meta( $post->ID, 'quiz_questions', true );
        $questions = get_posts( array('post_type' => 'mcq-question', 'posts_per_page' => -1, 'post_status' => 'publish'));
        ?>
        <p class="meta-options">
            <label for="quiz_questions" class="post-format-icon" style="width: 15%;"><b><?php echo esc_html__( 'Select Quiz Questions', 'mcq-quiz' ) ?></b></label>
            <select name="quiz_questions[]" id="quiz_questions" style="width: 80%;" class="select_quiz_questions" multiple>
                <?php
                if( is_array( $questions ) && count( $questions ) ) {
                    foreach ( $questions as $question ) {
                        $selected = !empty( $value ) && in_array( $question->ID, $value ) ? 'selected' : '';
                        echo '<option value="'.$question->ID.'"'.$selected.'>'.$question->post_title. '</option>';
                    }
                }else {
                    echo '<option value = "">No Questions Found'.'</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }

    /*
 * Candidate Shortcode
 */
    function mcq_quiz_shortcode_metabox( $post ) {
        ?>
        <div class="meta-box">
            <p class="meta-options">
                [multiple-mcq-quiz id="<?php echo $post->ID; ?>"]
            </p>
        </div>
        <?php
    }

    /**
     * Add question answers
     *
     * @param WP_POST $post Post object.
     *
     * @since 1.0.0
     */
    public function mcq_add_question_answers( $post ) {
        ?>
        <div class="meta-box">
            <p class="meta-options" style="display: flex;">
                <label for="mcq_answers_one" class="post-format-icon" style="width: 160px"><b><?php echo esc_html__( 'First Question Answer', 'mcq-quiz' ) ?></b></label>
                <input type="text" name="mcq_answers_one" class="post-format" style="width: 30%" id="mcq_answers_one" value="<?php echo get_post_meta( $post->ID, 'mcq_answers_one', true ); ?>">
            </p>
            <p class="meta-options" style="display: flex;">
                <label for="mcq_answers_two" class="post-format-icon" style="width: 160px"><b><?php echo esc_html__( 'Second Question Answer', 'mcq-quiz' ) ?></b></label>
                <input type="text" name="mcq_answers_two" class="post-format" style="width: 30%" id="mcq_answers_two" value="<?php echo get_post_meta( $post->ID, 'mcq_answers_two', true ); ?>">
            </p>
            <p class="meta-options" style="display: flex;">
                <label for="mcq_answers_three" class="post-format-icon" style="width: 160px"><b><?php echo esc_html__( 'Third Question Answer', 'mcq-quiz' ) ?></b></label>
                <input type="text" name="mcq_answers_three" class="post-format" style="width: 30%" id="mcq_answers_three" value="<?php echo get_post_meta( $post->ID, 'mcq_answers_three', true ); ?>">
            </p>
            <p class="meta-options" style="display: flex;">
                <label for="mcq_answers_four" class="post-format-icon" style="width: 160px"><b><?php echo esc_html__( 'Forth Question Answer', 'mcq-quiz' ) ?></b></label>
                <input type="text" name="mcq_answers_four" class="post-format" id="mcq_answers_four" style="width: 30%" value="<?php echo get_post_meta( $post->ID, 'mcq_answers_four', true ); ?>">
            </p>
            <p class="meta-options" style="display: flex;">
                <?php
                $one = get_post_meta( $post->ID, 'mcq_answers_one', true );
                $two = get_post_meta( $post->ID, 'mcq_answers_two', true );
                $three = get_post_meta( $post->ID, 'mcq_answers_three', true );
                $four = get_post_meta( $post->ID, 'mcq_answers_four', true );
                $value = get_post_meta( $post->ID, 'correct_answer', true );
                ?>
                <label for="correct_answer" class="post-format-icon" style="width: 160px" ><b><?php echo esc_html__( 'Select Correct Answer', 'mcq-quiz' ) ?></b></label>
                <select name="correct_answer" id="correct_answer" style="width: 30%">
                    <option value="">Select Answer</option>
                    <option value="mcq_answers_one" <?php echo selected( $value, 'mcq_answers_one' ); ?>><?php echo ! empty( $one ) ? $one : "First" ; ?></option>
                    <option value="mcq_answers_two" <?php echo selected( $value, 'mcq_answers_two' ); ?>><?php echo ! empty( $two ) ? $two : "Second" ; ?></option>
                    <option value="mcq_answers_three" <?php echo selected( $value, 'mcq_answers_three' ); ?>><?php echo ! empty( $three ) ? $three : "Third" ; ?></option>
                    <option value="mcq_answers_four" <?php echo selected( $value, 'mcq_answers_four' ); ?>><?php echo ! empty( $four ) ? $four : "Forth" ; ?></option>
                </select>
            </p>
        </div>
        <?php
    }

    /**
     * Save MCQ quiz and question values.
     *
     * @param int $post_id Post ID.
     *
     * @since 1.0.0
     */
    public function mcq_save_meta($post_id, $post, $update) {

        if ( ! $update ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            return;
        }
        if ( 'mcq-quiz' == get_post_type( $post_id ) ) {
            if ( array_key_exists( 'quiz_questions', $_REQUEST ) ) {
                update_post_meta(
                    $post_id,
                    'quiz_questions',
                    $_REQUEST['quiz_questions']
                );
            } else {
                update_post_meta(
                    $post_id,
                    'quiz_questions',
                    ''
                );
            }
        }
        if ( 'mcq-question' == get_post_type( $post_id ) ) {
            update_post_meta( $post_id, 'mcq_answers_one', ! empty( $_REQUEST['mcq_answers_one'] ) ? sanitize_text_field( $_REQUEST['mcq_answers_one'] ) : '' );
            update_post_meta( $post_id, 'mcq_answers_two', ! empty( $_REQUEST['mcq_answers_two'] ) ? sanitize_text_field( $_REQUEST['mcq_answers_two'] ) : '' );
            update_post_meta( $post_id, 'mcq_answers_three', ! empty( $_REQUEST['mcq_answers_three'] ) ? sanitize_text_field( $_REQUEST['mcq_answers_three'] ) : '' );
            update_post_meta( $post_id, 'mcq_answers_four', ! empty( $_REQUEST['mcq_answers_four'] ) ? sanitize_text_field( $_REQUEST['mcq_answers_four'] ) : '' );
            update_post_meta( $post_id, 'correct_answer', ! empty( $_REQUEST['correct_answer'] ) ? sanitize_text_field( $_REQUEST['correct_answer'] ) : '' );
        }
    }
}

new Quiz_Meta_boxes();
