//
//  LoginViewController.h
//  HopingForAWish
//
//  Created by Austin Chan on 11/25/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface LoginViewController : UIViewController <UITextFieldDelegate>
@property (weak, nonatomic) IBOutlet UIButton *backToRegisterButton;
@property (weak, nonatomic) IBOutlet UIButton *loginButton;
@property (weak, nonatomic) IBOutlet UITextField *emailField;
@property (weak, nonatomic) IBOutlet UITextField *passwordField;
@property (weak, nonatomic) IBOutlet UIActivityIndicatorView *activity;

- (IBAction)backToRegister:(id)sender;
- (IBAction)login:(id)sender;

- (void)readyToLogin;
- (void)notReadyToLogin;

@end
