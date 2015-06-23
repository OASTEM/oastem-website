<?php
require('../common.php');

$templ->setTitle('STEM Summer');
$templ->render('header');
?>
    <div id="jumbotron">
        <img src="Jumbotron.jpg">
        <a href="http://oastem.org/summersignup" target="_blank"><img src="Signup.jpg"></a>
    </div>
	<section>
        <div class="post">
            <div id="left">
                <h1>Introduction</h1>
                <p>We are Oxford Academy STEM. We are more than just an on campus club. We aim to support the bright young minds of anyone in our region. Our goal for students is simple: To learn, compete, and thrive. Members of OA STEM participate in STEM related competitions, which range from test taking building robots which compete against others. Don't worry if you don't feel ready for competition, we welcome in students without experience because education is our number one priority. You can be a part of one, or all four of our departments. If you are interested in finding out what goes on in each of these meetings, keep exploring this page!</p>
            </div>
            <div id="right">
                <img src="Board.jpg">
            </div>
        </div>
        
        <div class="post">
            <div id="left">
                <h1>When</h1>
                <p>Each department will meet once a week, with the exception of Engineering, which meets twice a week, over the six week period of June 22nd and July 31st. This allows students to choose which departments they are interested in attending. The specific meeting times are listed below.</p>
                <table id="when">
                    <tr>
                        <td bgcolor="#3ab14a"><span>Science*</span></td>
                        <td bgcolor="#7398cf"><span>Technology</span></td>
                        <td bgcolor="#ed5025"><span>Engineering</span></td>
                        <td bgcolor="#ebaf20"><span>Mathematics</span></td>
                    </tr>
                    <tr>
                        <td><strong>Mondays</strong><br>9:00AM-3:00</td>
                        <td><strong>Fridays</strong><br>9:00AM-12:00</td>
                        <td><strong>Th. &amp; Sat.</strong><br>9:00AM-12:00</td>
                        <td><strong>Tuesdays</strong><br>3:30PM-6:30</td>
                    </tr>
                </table>
                <p id="noIndent">*Science meetings may have their times adjusted as members deem convenient.</p>
            </div>
            <div id="right">
                <h1>Where</h1>
                <p id="noIndent"><a href="https://www.google.com/maps/place/Oxford+Academy/@33.8224281,-118.0425098,18z/data=!3m1!4b1!4m2!3m1!1s0x80dd2e98997e6095:0xf86122ccefa379ec" target="_blank">Oxford Academy, 5172 Orange Ave Cypress, CA | Room 301**</a></p>
                <img src="map.jpg">
                <p id="noIndent">**Room location subject to change</p>
            </div>
            <div id="jumpTo">
                <h1>Jump To</h1>
                <table>
                    <tr>
                        <td>
                            <a href="#science"><img class="top" src="Science.svg">
                            </td></a>
                        <td>
                            <a href="#technology"><img class="top" src="Technology.svg">
                            </td></a>
                        <td>
                            <a href="#engineering"><img class="top" src="Engineering.svg">
                            </td></a>
                        <td>
                            <a href="#mathematics"><img class="top" src="Mathematics.svg">
                            </td></a>
                        <td>
                            <a href="#faq"><img class="top" src="FAQ.svg">
                            </td></a>
                    </tr>
                </table>
            </div>
        </div>
        <img src="line.png">
        <div class="department"><a name="science" class="offset"></a>
            <h1><img src="Sci%20-%20Atom.svg">Science</h1>
            <p id="largerText">Meetings every Monday from 9:00AM to 3:00PM under the direction of Celine Veys, Tiffany Lwin, Abigail Zhong, Samuel Mun, and Mr. Fournier.</p>
            <div id="left">
                <p>The Science Department has two main competitions during the school year: Science Bowl and Science Olympiad. Both competitions feature a variety of knowledge, whether it be the physical sciences or biology. Science Bowl is a much faster paced competition; teams of five face off against each other in a buzzer type gameplay. This exciting competition really pushes timing and knowledge to the limit. If speed is not your thing, Science Olympiad offers a multitude of other subjects.</p>
                <a href="http://science.energy.gov/wdts/nsb/" target="_blank"><img src="SciBowl.svg"></a>
            </div>
            <div id="right">
                <a href="http://soinc.org/" target="_blank"><img src="SciOly.svg"></a>
                <p>Science Olympiad (SciOly) is a massive competition with 23 events, each with up to 2-3 people per event. For now, Science Olympiad is limited only to High School students. SciOly includes test taking and build events. Students of varying skillsets work together to score the most points for their team. You might even get to learn about sciences you've never heard of before if you sign up for SciOly!</p>
            </div>
        </div>

        <img src="line.png">

        <div class="department"><a name="technology" class="offset"></a>
            <h1><img src="Tech%20-%20Pointer.svg">Technology</h1>
            <p id="largerText">Meetings every Friday from 9:00AM to 12:00PM under the direction of Michael Duong and Peter Yang.</p>
            <div id="left">
                <p>The Technology Department aims to teach the basics of programming to students while helping more experienced students continue their skill development. Over the six week summer program, students will be taught in the Java programming language from the bottom up for the younger students. Those with more experience will get to create more interactive programs by creating graphical user interfaces.</p>
                <img src="programming.jpg">
            </div>
            <div id="right">
                <img src="Code.jpg">
                <p>Just scratching the surface of Computer Science with Java should be enough to get students to determine whether or not they wish to continuing developing skills. Of course we are biased and reccomend that everyone learn to code, but the summer program is a great way to find out what the hype about programming is. After the summer session, members in the technology department will look into further applications of programming such as web development, server management, or Android app creation.</p>
            </div>
        </div>

        <img src="line.png">

        <div class="department"><a name="engineering" class="offset"></a>
            <h1><img src="Eng%20-%20Gear.svg">Engineering</h1>
            <p id="largerText">Meetings every Thursday and Saturday from 9:00AM to 12:00PM under the direction of Byron Aguilar and many other adult mentors from NASA JPL, Boeing, and HP.</p>
            <div id="left">
                <p>The Engineering Department, in a nutshell, builds robots. They have two main competitions, VEX, and FRC, which are both good ways to learn the gist of robotic engineering. VEX provides students with premade parts and a smaller (18x18x18in.) robot requirement while FRC goes big with a robot that can be as tall as some students. Though younger students, around the Junior High age will stick with VEX, being a part of FRC is not out of the question for them!</p>
                <img src="frcbot.JPG">
            </div>
            <div id="right">
                <img src="doubledunkindonut.JPG">
                <p>Students will get exposed to many aspects of engineering just by working on these robots. This includes working with mechanical structures or wiring them up. Besides being able to mechanically engineer a robot and learn electrical engineering, students may also get a chance to learn CAD (Computer Aided Design) software which is common knowledge for almost any type of engineer in today's work force.</p>
            </div>
        </div>

        <img src="line.png">

        <div class="department"><a name="mathematics" class="offset"></a>
            <h1><img src="Math%20-%20Pi.svg">Mathematics</h1>
            <p id="largerText">Meetings every Tuesday from 3:30PM to 6:30PM under the direction of Sean Park.</p>
            <div id="left">
                <p>The Math Department has many different events such as Math Day at the beach, CalTech Harvey Mudd Math Competition and Pepperdine Math Competition. In addition to that, we help students prepare for the American Mathematics Competition (AMC) which is a nation wide competition. The AMC is well recognized and some schools like MIT has a section on their college application to put down an AMC score.</p>
                <img src="amc.jpg">
            </div>
            <div id="right">
                <img src="calculations.jpg">
                <p>Take note that this type of math will not be like that in a traditional classroom setting. These math problems test students on how well they can apply concepts; not how many concepts they know. It doesn't take a calculus student to be able to solve these problems. We are just looking for anyone who is interested in math and would like to work their problem solving skills!</p>
            </div>
        </div>

        <img src="line.png">

        <div class="department"><a name="faq" class="offset"></a>
            <h1><img src="Admin%20-%20Puzzle.svg">Frequenty Asked Questions</h1>
            <div id="noIndent">
                <p>Q: What is STEM?
<br>A: STEM stands for Science, Technology, Engineering, and Math. We are a
competitive team which helps students prepare for a number of competitions
throughout the school year. You don’t have to join all four of the departments, but you are welcome to join as many departments as you would like.</p>
                <br>
                <p>Q: Who is eligible to be a member?<br>A: Anyone from anywhere is welcome to join our meetings provided that they are between 7th and 12th grade.</p>
                <br>
                <p>Q: If I am not attending Oxford Academy, will I still be able to participate in meetings and competitions?<br>A: You will definitely be able to come to our meetings, though registration in competitions may vary from competition to competition due to the requirements of the competition host.</p>
                <br>
                <p>Q: When are meetings?<br>A: Science will be on Mondays from 9AM to 3PM for now (times will be adjusted as members deem convenient); Technology will be on Fridays from 9AM to 12PM; Engineering will be on Thursdays and Saturdays from 9AM to 12PM; Mathematics will be on Tuesdays from 3:30PM to 6:30PM.</p><br>
                <p>Q: How many departments can be joined?<br>A: As many as you want!</p>
                <br>
                <p>Q: Why should I go to Summer with STEM?
<br>A: People who go to Summer with STEM can gain experience in each department to see which department suits them best, so they can select which department to join when the school year comes.  Additionally, those who go to Summer with STEM will be more experienced and prepared when school starts than those who don’t.</p>
                <br>
                <p>Q: I still have an unanswered question!<br>A: That's not a question! But if you want to ask something directly to us, you can always hit us up on our <a href="http://ask.fm/OASTEM" target="_blank">ask.fm</a> or <a href="../contact/">send us a message</a>.</p>
            </div>
        </div>
    </section>
<div id="jumbotron">
    <a href="http://oastem.org/summersignup" target="_blank"><img src="Signup.jpg"></a>
</div>
<?php
$templ->render('footer');
?>