let str = "abcdez"


function rep(str){
let arr = str.split('');

for(let i = 0; i< arr.length ; i++){
    // for(let j = 0; j< arr.length ; j++){
        if(arr[i] === arr[i+1]){
            return false;
        }else{
            return true;
        }
        
    // }
}



}


console.log(rep(str));
console.log(rep("abbghg"));