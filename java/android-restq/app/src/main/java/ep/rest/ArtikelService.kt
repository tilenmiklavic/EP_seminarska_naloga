package ep.rest

import com.google.gson.GsonBuilder
import retrofit2.Call
import retrofit2.Retrofit
import retrofit2.converter.gson.GsonConverterFactory
import retrofit2.http.*


object ArtikelService {

    interface RestApi {

        companion object {
            // AVD emulator
            //const val URL = "http://192.168.1.76/netbeans/mvc-rest/api/"
            // Genymotion
            const val URL = "http://192.168.2.102/netbeans/EP_seminarska_naloga/api/"
        }

        @GET("artikli")
        fun getAll(): Call<List<Artikel>>

        @GET("artikli/{id}")
        fun get(@Path("id") id: Int): Call<Artikel>

        @FormUrlEncoded
        @POST("artikli")
        fun insert(@Field("avtor") avtor: String,
                   @Field("ime") ime: String,
                   @Field("cena") cena: Int): Call<Void>

        @FormUrlEncoded
        @PUT("artikli/{id}")
        fun update(@Path("id") id: Int,
                   @Field("avtor") avtor: String,
                   @Field("ime") ime: String,
                   @Field("cena") cena: Int): Call<Void>

        @DELETE("artikli/{id}")
        fun delete(@Path("id") id: Int): Call<Void>
    }

    var gson = GsonBuilder()
            .setLenient()
            .create()


    val instance: RestApi by lazy {
        val retrofit = Retrofit.Builder()
                .baseUrl(RestApi.URL)
                .addConverterFactory(GsonConverterFactory.create())
                .build()

        retrofit.create(RestApi::class.java)
    }
}
