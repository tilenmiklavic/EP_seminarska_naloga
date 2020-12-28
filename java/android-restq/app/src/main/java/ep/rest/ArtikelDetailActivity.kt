package ep.rest

import android.app.AlertDialog
import android.content.Intent
import android.os.Bundle
import android.util.Log
import androidx.appcompat.app.AppCompatActivity
import kotlinx.android.synthetic.main.activity_artikel_detail.*
import kotlinx.android.synthetic.main.content_artikel_detail.*
import retrofit2.Call
import retrofit2.Callback
import retrofit2.Response
import java.io.IOException

class ArtikelDetailActivity : AppCompatActivity() {
    private var artikel: Artikel = Artikel()

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_artikel_detail)
        setSupportActionBar(toolbar)

        fabEdit.setOnClickListener {
            val intent = Intent(this, ArtikelFormActivity::class.java)
            intent.putExtra("ep.rest.book", artikel)
            startActivity(intent)
        }

        fabDelete.setOnClickListener {
            val dialog = AlertDialog.Builder(this)
            dialog.setTitle("Confirm deletion")
            dialog.setMessage("Are you sure?")
            dialog.setPositiveButton("Yes") { _, _ -> deleteArtikel() }
            dialog.setNegativeButton("Cancel", null)
            dialog.create().show()
        }


        supportActionBar?.setDisplayHomeAsUpEnabled(true)

        val id = intent.getIntExtra("ep.rest.id", 0)

        if (id > 0) {
            ArtikelService.instance.get(id).enqueue(OnLoadCallbacks(this))
        }
    }

    private fun deleteArtikel(): Unit {
        ArtikelService.instance.delete(this.artikel.id).enqueue(object : Callback<Void> {
            private val tag = this::class.java.canonicalName

            override fun onFailure(call: Call<Void>, t: Throwable) {
                Log.w(tag, "Napaka: ${t.message}", t)
            }

            override fun onResponse(call: Call<Void>, response: Response<Void>) {
                if (response.isSuccessful) {
                    val intent = Intent(getApplicationContext(), MainActivity::class.java)
                    startActivity(intent);
                }
            }
        })
    }


    private class OnLoadCallbacks(val activity: ArtikelDetailActivity) : Callback<Artikel> {
        private val tag = this::class.java.canonicalName

        override fun onResponse(call: Call<Artikel>, response: Response<Artikel>) {
            activity.artikel = response.body() ?: Artikel()

            Log.i(tag, "Got result: ${activity.artikel}")

            if (response.isSuccessful) {
                activity.tvBookDetail.text = activity.artikel.avtor
                activity.toolbarLayout.title = activity.artikel.ime
            } else {
                val errorMessage = try {
                    "An error occurred: ${response.errorBody()?.string()}"
                } catch (e: IOException) {
                    "An error occurred: error while decoding the error message."
                }

                Log.e(tag, errorMessage)
                activity.tvBookDetail.text = errorMessage
            }
        }

        override fun onFailure(call: Call<`Artikel`>, t: Throwable) {
            Log.w(tag, "Error: ${t.message}", t)
        }
    }
}

