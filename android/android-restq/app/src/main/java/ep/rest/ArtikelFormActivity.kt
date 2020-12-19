package ep.rest

import android.content.Intent
import android.os.Bundle
import androidx.appcompat.app.AppCompatActivity
import android.util.Log
import kotlinx.android.synthetic.main.activity_artikel_form.*
import kotlinx.android.synthetic.main.activity_artikel_form.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class ArtikelFormActivity : AppCompatActivity(), Callback<Void> {

    private var artikel: `Artikel`? = null

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_artikel_form)

        btnSave.setOnClickListener {
            val avtor = etAuthor.text.toString().trim()
            val ime = etTitle.text.toString().trim()
            val cena = etPrice.text.toString().trim().toInt()

            if (artikel == null) { // dodajanje
                ArtikelService.instance.insert(avtor, ime, cena).enqueue(this)
            } else { // urejanje
                ArtikelService.instance.update(artikel!!.id, avtor, ime, cena).enqueue(this)
            }
        }

        val book = intent?.getSerializableExtra("ep.rest.artikel") as `Artikel`?
        if (book != null) {
            etAuthor.setText(artikel?.avtor)
            etTitle.setText(artikel?.ime)
            etPrice.setText(artikel?.cena.toString())
            this.artikel = artikel
        }
    }

    override fun onResponse(call: Call<Void>, response: Response<Void>) {
        val headers = response.headers()

        if (response.isSuccessful) {
            val id = if (artikel == null) {
                // Preberemo Location iz zaglavja
                Log.i(TAG, "Insertion completed.")
                val parts = headers.get("Location")?.split("/".toRegex())?.dropLastWhile { it.isEmpty() }?.toTypedArray()
                // spremenljivka id dobi vrednost, ki jo vrne zadnji izraz v bloku
                parts?.get(parts.size - 1)?.toInt()
            } else {
                Log.i(TAG, "Editing saved.")
                // spremenljivka id dobi vrednost, ki jo vrne zadnji izraz v bloku
                artikel!!.id
            }

            val intent = Intent(this, ArtikelDetailActivity::class.java)
            intent.putExtra("ep.rest.id", id)
            startActivity(intent)
        } else {
            val errorMessage = try {
                "An error occurred: ${response.errorBody()?.string()}"
            } catch (e: IOException) {
                "An error occurred: error while decoding the error message."
            }

            Log.e(TAG, errorMessage)
        }
    }

    override fun onFailure(call: Call<Void>, t: Throwable) {
        Log.w(TAG, "Error: ${t.message}", t)
    }

    companion object {
        private val TAG = ArtikelFormActivity::class.java.canonicalName
    }
}
