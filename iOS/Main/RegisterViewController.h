//
//  RegisterViewController.h
//  HW Santa
//
//  Created by Austin Chan on 11/24/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface RegisterViewController : UIViewController <UITextFieldDelegate, NSURLConnectionDelegate>{
    CGPoint originalCenter;
}
@property (weak, nonatomic) IBOutlet UITextField *emailField;
@property (weak, nonatomic) IBOutlet UITextField *passwordField;
@property (weak, nonatomic) IBOutlet UITextField *confirmPasswordField;
@property (weak, nonatomic) IBOutlet UIButton *cancelButton;
@property (weak, nonatomic) IBOutlet UIButton *registerButton;
@property (weak, nonatomic) IBOutlet UIImageView *imageView;
@property (weak, nonatomic) IBOutlet UILabel *swipeToSignIn;
@property (weak, nonatomic) IBOutlet UILabel *signUpLabel;

- (IBAction)cancelAction:(id)sender;
- (IBAction)registerAction:(id)sender;

@end
