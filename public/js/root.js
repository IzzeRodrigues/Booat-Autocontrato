export default function HOME() {
    let url = location.href;
    if(
        url.includes('localhost')
        || url.includes('127.0.0.1')
        || url.includes('127.0.0.1:8000')
    ){
        return 'http://127.0.0.1:8000'
    } else {
        return 'https://seagree.com.br'
    }
}
