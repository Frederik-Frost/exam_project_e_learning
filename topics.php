<?php

require_once("session-check.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    *{
        font-family: sans-serif;
    }
    #topics{
        display: flex;
        gap: 12px;
    }
    .topic{
        display: flex;
        flex-direction: row;
        gap: 12px;
    }

    table, th, tr {
        border:1px solid black;
    }
    #chosenTopic{display: none}
</style>
<body>
    <h1>Hello <?= $_SESSION['user_name']; ?> </h1>

    <h3>Topics:</h3>
    <div id="topics">
        <table id="availableTopics">
            <tr>
                <th>Available topics</th> 
            </tr>    

        </table>
        <table id="allTopics">
            <tr>
                <th>All topics</th>
            </tr>

        </table>
    </div>
    
    <div id="chosenTopic">
        <h3>Chosen topic:</h3>
        <!-- <div class="activityList"></div> -->
        <div class="topicComments">
            <h3>Comments for this topic</h3>
            <div class="comments"></div>
            <!-- <div  class="createComment">
                <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                <button onclick="writeMongoComment()" type="button">Comment</button>
            </div> -->
        </div>
    </div>
    <div id="activities">
    
    </div>


    <script>

    window.addEventListener("DOMContentLoaded", () => {
        getAvailableTopics()
        getAllTopics()
    })
    async function getAllTopics(){
        let conn = await fetch('api/get-all-topics.php', {
                'method': 'POST',
                'Content-Type': 'application/json'
            })
        let res = await conn.json()
        console.log(res)
        res.forEach(topic => {
            console.log(topic)
            const topicElement = `<tr class="topic"> <td>${topic.topic_name}</td> </tr>`
            document.querySelector("#allTopics").insertAdjacentHTML('beforeend', topicElement)

        })

    }
    async function getAvailableTopics(){
        let conn = await fetch('api/get-available-topics.php', {
                'method': 'POST',
                'Content-Type': 'application/json'
            })
        let res = await conn.json()
        console.log(res)
        res.forEach(topic => {
            console.log(topic)
            const topicElement = `<tr class="topic"> <td>${topic.topic_name}</td> <td> <button onclick="clickedTopic(${topic.topic_id}); return false"> Go to activities </button></td> </tr> `
            document.querySelector("#availableTopics").insertAdjacentHTML('beforeend', topicElement)

        })
    }

    async function clickedTopic(id){
        console.log(id)
        let topicID = new FormData();
        topicID.append("id", id)

        let conn = await fetch('api/get-activities.php', {
                'method': 'POST',
                'Content-Type': 'application/json',
                'body' : topicID
            })
        let res = await conn.json()
        console.log(res)
        document.querySelector("#chosenTopic").style.display = "block"
        res.forEach(activity => {
            const activityContents = `<div class="activity">
                                        <div class="title">
                                            <h3>${activity.activity_name}</h3>
                                        </div>
                                        <div class="description">
                                            <h5>${activity.activity_description}</h5>
                                        </div>
                                        <button type="button" onclick="getMongoActivity(${activity.activity_id}); return false">Read this</button>
                                    </div>`
            document.querySelector("#chosenTopic").insertAdjacentHTML('beforeend', activityContents)
        })
        document.querySelector("#chosenTopic h3").insertAdjacentHTML('afterbegin', `<button onclick=getNewTopic(${id});>Did you finish this topic?</button>`)
        getComments(id);
    }
    
    async function getComments(id){
        let topicID = new FormData();
        topicID.append("id", id)
        let conn = await fetch('api/read-comments.php', {
            'method': 'POST',
            'Content-Type': 'application/json',
            'body' : topicID
        })
        let res = await conn.json()
        console.log(res)
        res.forEach(comment => {
            const commentNode = `<div class="comment">
                                <div class="name">
                                <h3>${comment.user_name}</h3>
                                </div>
                                <div class="text">
                                <p>${comment.comment}</p>
                                </div>
                            </div>`
            document.querySelector(".comments").insertAdjacentHTML('beforeend', commentNode)
        })
        
        document.querySelector(".topicComments").insertAdjacentHTML('beforeend', ` <div  class="createComment">
                <textarea name="comment" id="comment" cols="30" rows="10"></textarea>
                <button onclick="writeMongoComment(${id})" type="button">Comment</button>
            </div>`)
    }

    async function writeMongoComment(id){
        let commentText = document.querySelector("#comment")
        console.log(id)
        console.log(commentText.value)

        let commentData = new FormData();
        commentData.append("id", id)
        commentData.append("comment", commentText.value)
        let conn = await fetch('api/write-comments.php', {
            'method': 'POST',
            'Content-Type': 'application/json',
            'body' : commentData
        })
    }
    async function getMongoActivity(activity){
        let activityID = new FormData();
            activityID.append("id", activity)

            let conn = await fetch('api/get-mongo-contents.php', {
                'method': 'POST',
                'Content-Type': 'application/json',
                'body' : activityID
            })
            let res = await conn.json()
            console.log(res)
            const activityContents = `<div class="activityContent">
                                        <p>${res.text}</p>
                                     </div>`
            document.querySelector("#chosenTopic").insertAdjacentHTML('beforeend', activityContents)
    }

    async function getNewTopic(topicID){
        console.log(topicID)
        let topicData = new FormData();
        topicData.append("id", topicID)

        let conn = await fetch('api/unlock-topic.php', {
                'method': 'POST',
                'Content-Type': 'application/json',
                'body' : topicData
            })

        let res = await conn.text()
        console.log(res)

        
    }

    </script>
</body>
</html>