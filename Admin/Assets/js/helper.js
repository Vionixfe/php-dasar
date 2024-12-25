//Slugify
const slugify = (text) => {
    return text.trim().toLowerCase()
    .replace(/\s+/g, '-') //ganti dengan spasi
    .replace(/[^\w\-]+/g, '') //Hapus karakter non=alphanumeric// 
    .replace(/-+/g, '-'); // Ganti beberapa - dengan satu
}