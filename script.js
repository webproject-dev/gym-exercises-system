function Exercise(group, name, level){
    this.group=group;
    this.name=name;
    this.level=level;
}

function Plan(day,exercise,reps){
    this.day=day;
    this.exercise=exercise;
    this.reps=reps;
}

var exercises=[
    new Exercise("Chest", "Bench Press", "Intermediate"),
    new Exercise("Chest", "Incline Dumbell Press", "Intermediate"),
    new Exercise("Chest", "Chest Fly", "Beginner"),
    new Exercise("Legs", "Squats", "Beginner"),
    new Exercise("Legs", "Leg Press", "Intermediate"),
    new Exercise("Legs", "Lunges", "Beginner"),
    new Exercise("Back", "Deadlift", "Advanced"),
    new Exercise("Back", "Pull Ups", "Intermediate"),
    new Exercise("Back", "Lat Pulldown", "Beginner"),
    new Exercise("Arms", "Bicep Curl", "Beginner"),
    new Exercise("Arms","Tricep Dips", "Intermediate"),
    new Exercise("Arms", "Hammer Curl", "Beginner"),
    new Exercise("Shoulders", "Shoulder Press","Intermediate"),
    new Exercise("Shoulders", "Lateral Raise", "Beginner"),
    new Exercise("Shoulders","Front Raise", "Beginner")
];

var plans=[
    new Plan("Sunday", "Chest", 10),
    new Plan("Monday", "Legs", 12),
    new Plan("Tuesday", "Rest", "-"),
    new Plan("Wednesday", "Back", 10),
    new Plan("Thursday", "Arms", 12),
    new Plan("Friday", "Rest", "-"),
    new Plan("Saturday", "Full Body", 15)
    
];

function showExercises() {
    var body=document.getElementById("exerciseBody");
    var text= "";
    
    for(var i=0; i<exercises.length;i++){
        text+= "<tr><td>" + exercises[i].group + "</td>" +
               "<td>" + exercises[i].name + "</td>" + 
               "<td>" + exercises[i].level+ "</td></tr>";

    }
    body.innerHTML = text;
}

function showPlans() {
    var body=document.getElementById("planBody");
    var text= "";

    for(var i=0; i<plans.length;i++){
        text+= "<tr><td>" + plans[i].day + "</td>" +
               "<td>" + plans[i].exercise + "</td>" + 
               "<td>" + plans[i].reps+ "</td></tr>";

    }

    body.innerHTML = text;

}
function addExercise(){
    var muscleGroup =document.getElementById("group").value;
    var exerciseName=document.getElementById("ename").value;
    var difficulty=document.getElementById("level").value;

    var newExercise= new Exercise(muscleGroup, exerciseName, difficulty);
    exercises.push(newExercise);

    showExercises();
}

function addPlan(){
    var dayName=document.getElementById("day").value;
    var exerciseType=document.getElementById("pexercise").value;
    var numberOfReps=document.getElementById("reps").value;

    var newPlan= new Plan(dayName,exerciseType,numberOfReps);
    plans.push(newPlan);

    showPlans();
}

function findExercise() {
    var key = document.getElementById("searchExercise").value;
    var result = "Not found";

    for(var i=0; i < exercises.length; i++){
        if(exercises[i].name.toLowerCase()==key.toLowerCase()){
            result=exercises[i].group + " - " + exercises[i].level;
            break;
        
        }

    }

    document.getElementById("exerciseResult").innerHTML=result;

}

function findPlan(){
    var key = document.getElementById("searchPlan").value;
    var result = "Not found";

    for(var i=0; i < plans.length; i++){
        if(plans[i].day.toLowerCase()==key.toLowerCase()){
            result=plans[i].exercise + " - " + plans[i].reps;
            break;
        
        }

    }

    document.getElementById("planResult").innerHTML=result;


}