<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
/**
 * @group Авторизация
 *
 * Модуль авторизации в системе
 */
class AuthController extends Controller
{
    /**
     * Авторизация в системе
     * @response 403 {"errors":[{"message":"\u041d\u0435\u0432\u0435\u0440\u043d\u044b\u0439 \u043d\u043e\u043c\u0435\u0440 \u0442\u0435\u043b\u0435\u0444\u043e\u043d\u0430 \u0438\u043b\u0438 \u043f\u0430\u0440\u043e\u043b\u044c"}]}
     * @response 200 {"message":"\u0423\u0441\u043f\u0435\u0448\u043d\u0430\u044f \u0430\u0432\u0442\u043e\u0440\u0438\u0437\u0430\u0446\u0438\u044f","access_token":"***********************************************************","token_type":"Bearer","user":{"name":"\u0420\u0430\u0445\u043c\u043e\u043d\u043e\u0432 \u041e\u0434\u0438\u043b\u0436\u043e\u043d \u041e\u0440\u0438\u0444\u0436\u043e\u043d \u0443\u0433\u043b\u0438","phone":"998909999341"}}
     * @responseField message Информация о результате авторизации
     * @responseField access_token Токен авторизации
     * @responseField token_type Тип токена
     * @responseField user Информация о пользователе
     * @responseField user.name Имя пользователя
     * @responseField user.phone Номер телефона пользователя
     * @responseField errors Информация об ошибках
     * @responseField errors.message Информация об ошибке
     *
     */
    public function login(LoginRequest $request):JsonResponse
    {
        $credentials = $request->only('phone', 'password');
        #region check client
        if (!auth()->attempt($credentials,$request->get('remember_me'))) {
            throwError(__('auth.failed'), 403);
        }
        #endregion
        #region check user
        $user = $request->user();

        #endregion
        #region create token
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->plainTextToken;
        #endregion
        #region return token
        return success([
            'message' => __('auth.success'),
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'=>['name'=>$user->name,'phone'=>$user->phone]

        ]);
        #endregion
    }
    /**
     * Выход из системы
     * @authenticated
     * @response 200 {"message":"\u0412\u044b\u0445\u043e\u0434 \u0438\u0437 \u0441\u0438\u0441\u0442\u0435\u043c\u044b \u043f\u0440\u043e\u0448\u0435\u043b \u0443\u0441\u043f\u0435\u0448\u043d\u043e"}
     * @response 401 {"errors":[{"message":"\u041d\u0435\u0430\u0432\u0442\u043e\u0440\u0438\u0437\u043e\u0432\u0430\u043d\u043d\u044b\u0439 \u043f\u043e\u043b\u044c\u0437\u043e\u0432\u0430\u0442\u0435\u043b\u044c"}]}
     * @responseField message Информация о результате выхода из системы
     * @responseField errors Информация об ошибках
     * @responseField errors.message Информация об ошибке
     */
    public function logout(Request $request):JsonResponse
    {
        #region check client
        if (!$request->user()) {
            throwError(__('auth.unauthorized'), 401);
        }
        #endregion
        #region delete token
        $request->user()->currentAccessToken()->delete();
        #endregion
        #region return message
        return success([
            'message' => __('auth.logout')
        ],200);
        #endregion
    }

}
