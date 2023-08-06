edits=document.getElementsByClassName("edit");
Array.from(edits).forEach((element)=>{
    element.addEventListener("click",(e)=>{
        console.log("edit ", );
        tr=e.target.parentNode.parentNode;
        title=tr.getElementsByTagName("td")[0].innerText;
        description=tr.getElementsByTagName("td")[1].innerText;
        titleEdit.value=title;
        descriptionEdit.value=description;
        snoEdit.value=e.target.id;
    })
})

deletes=document.getElementsByClassName("delete");
Array.from(deletes).forEach((element)=>{
    element.addEventListener("click",(e)=>{
        sno=e.target.id;
        if(confirm("Are you sure want to delete !"))
        {
            window.location=`index.php?delete=${sno}`;
        }
    })
})