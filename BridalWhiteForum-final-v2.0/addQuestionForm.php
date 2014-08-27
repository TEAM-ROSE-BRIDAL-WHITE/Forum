<div class="addQuestion">
    <h2>Задай Въпрос: </h2><span class="closeQuestion">[X]</span>
    <form class="addQuestionForm" name="addQuestionForm" id="addQuestionForm">
        <div class="rightSide">
            <div class="leftSide">
                <label for="addQuestionField">Въпрос: </label>
            </div>
            <input type="text" name="addQuestionField" class="addQuestionField" id="addQuestionField" />
        </div>
        <div class="rightSide">
            <div class="leftSide">
                <label for="addQuestionContent">Съдържание: </label>
            </div>
            <textarea id="addQuestionContent" class="addQuestionContent"></textarea>
        </div>
        <div class="rightSide">
            <div class="leftSide">
                <label for="addQuestionChooseCategory">Категория: </label>
            </div>
            <select id="addQuestionChooseCategory" class="addQuestionChooseCategory">
                <?php
                $allCategories=new selectAllCategories();
                $allCategories->showThem();
                ?>
            </select>
        </div>
        <div class="rightSide">
            <div class="leftSide">
                <label for="addTags">Тагове: </label>
            </div>
            <input type="text" name="addTags" id="addTags" class="addTags" />
        </div>
        <input type="submit" name="submit" class="addQuestionSubmit" />
    </form>
</div>



<div class="addAnswerBody">
    <h2>Отговори: </h2><span class="closeAnswer">[X]</span>
    <form class="addAnswerForm" name="addAnswerForm" id="addAnswerForm">
        <div class="rightSide">
            <div class="leftSide">
                <label for="addAnswerContent">Отговор: </label>
            </div>
            <textarea id="addAnswerContent" class="addAnswerContent"></textarea>
        </div><br /><br /><br /><br />
        <input type="submit" value="Answer" class="addAnswerButton" />
    </form>
</div>
<?php
include_once('db.php');
class selectAllCategories extends dbConn{
    private $allCategories;
    public function __construct(){
        parent::connect();
    }
    private function selectThem(){
        $this->allCategories=parent::selectSomething('*', 'categories');
    }
    private function extractCategories(){
        $this->selectThem();
        $num=mysqli_num_rows($this->allCategories);
        for($i=0; $i<$num; $i++):
            $row=mysqli_fetch_object($this->allCategories);
            ?>
            <option value="<?php echo $row->cat_id; ?>">
                <?php echo $row->name; ?>
            </option>
            <?php
        endfor;
    }
    public function showThem(){
        $this->extractCategories();
    }
}
?>