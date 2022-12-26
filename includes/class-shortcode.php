<?php
defined( 'ABSPATH' ) || exit;

class Mcq_Quiz_Shortcode {
    /**
     * class constructor
     */
    public function __construct() {
        add_shortcode( 'multiple-mcq-quiz', array( $this, 'mcq_quiz_shortcode' ) );
        add_action('wp_ajax_mcq_quiz_submission', array($this, 'mcq_quiz_submission'));
        add_action('wp_ajax_nopriv_mcq_quiz_submission', array($this, 'mcq_quiz_submission'));
    }

    /**
     * Quiz shortcode for frontend
     *
     * @param array $attrs Attributes
     *
     * @return mixed
     * @since 1.0.0
     */
    public function mcq_quiz_shortcode( $attrs ) {
        $attrs = shortcode_atts(
            array( 'id' => '' ), $attrs
        );

        ob_start();
        if ( empty( $attrs['id'] ) ) {
            return 'No specific quiz is selected';
        }

        $id = $attrs['id'];
        $sl = 0;
        ?>
        <form action="" method="post" name="quiz-submission-form" class="mcq-quiz-submission">
            <?php
            $quiz_questions = get_post_meta( $id, 'quiz_questions', true );
            foreach ( $quiz_questions as $single ) {
                $question = get_post( $single );
                $sl++;
                ?>
                <p id="<?php echo $question->ID ?>"><?php echo $sl .'. '. $question->post_title; ?></p>

                <?php $first_answer = get_post_meta( $question->ID, 'mcq_answers_one', true ); ?>
                <?php if ( ! empty( $first_answer ) ): ?>
                    <input type="radio" id="mcq_answers_one" name="mcq-answers-<?php echo $question->ID ;?>" value="mcq_answers_one" required>
                    <label for="mcq_answers_one"><?php echo $first_answer; ?></label>
                <?php endif; ?>

                <?php $second_answer = get_post_meta( $question->ID, 'mcq_answers_two', true ); ?>
                <?php if ( ! empty( $second_answer ) ): ?>
                    <input type="radio" id="mcq_answers_two" name="mcq-answers-<?php echo $question->ID; ?>" value="mcq_answers_two" required>
                    <label for="mcq_answers_two"><?php echo $second_answer; ?></label>
                <?php endif; ?>

                <?php $third_answer = get_post_meta( $question->ID, 'mcq_answers_three', true ); ?>
                <?php if ( ! empty( $third_answer ) ): ?>
                    <input type="radio" id="mcq_answers_three" name="mcq-answers-<?php echo $question->ID; ?>" value="mcq_answers_three" required>
                    <label for="mcq_answers_three"><?php echo $third_answer; ?></label>
                <?php endif; ?>

                <?php $forth_answer = get_post_meta( $question->ID, 'mcq_answers_four', true ); ?>
                <?php if ( ! empty( $third_answer ) ): ?>
                    <input type="radio" id="mcq_answers_four" name="mcq-answers-<?php echo $question->ID; ?>" value="mcq_answers_four" required>
                    <label for="mcq_answers_four"><?php echo $forth_answer; ?></label>
                <?php endif; ?>
                <?php
            }
            ?>
            <br>
            <?php wp_nonce_field( 'mcq-quiz-nonce' ); ?>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" class="btn" value="submit" style="padding: 8px 30px; margin-top: 20px;" name="Submit">

        </form>

        <div class="result">

        </div>

        <?php

        return ob_get_clean();
    }

    /**
     * Quiz submission handler
     *
     * @since 1.0.0
     */
    public function mcq_quiz_submission() {
        $data = wp_parse_args( $_REQUEST['data'] );

        $id = $data['id'];
        $quiz_questions = get_post_meta( $id, 'quiz_questions', true );
        $submissions = array();
        $correct = 0;
        $wrong = 0;
        $total = count($quiz_questions);
        if ( is_array( $quiz_questions ) && count( $quiz_questions ) ) {
            foreach ( $quiz_questions as $question ) {
                $given = $data['mcq-answers-'.$question];
                $correct_answer = get_post_meta( $question, 'correct_answer', true );
                if( $correct_answer == $given ) {
                    $submissions[] = [
                        'question-id' => $question,
                        'correct' => 'yes',
                    ];
                } else {
                    $submissions[] = [
                        'question-id' => $question,
                        'correct' => 'no',
                    ];
                }
            }

        }

        $total = count( $submissions );
        if( is_array( $submissions ) && count( $submissions ) ) {
            foreach ( $submissions as $single ) {
                $correct += ( 'yes' == $single['correct'] ) ? 1 : 0;
                $wrong += ( 'no' == $single['correct'] ) ? 1 : 0;
            }
        }

        ?>
        <p>Total: <?php echo $total;?></p>
        <p>Correct: <?php echo $correct;?></p>
        <p>Wrong: <?php echo $wrong;?></p>
        <p>Number: <?php echo $correct . ' out of '. $total;?></p>

        <?php


        die();
    }
}

new Mcq_Quiz_Shortcode();